<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Payment;
use App\Models\Notification;
use App\Services\FcmNotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckMissedPayments extends Command
{
    protected $signature = 'app:check-missed-payments';
    protected $description = 'Notify drivers and companies if a payment has not been submitted by the due time';

    public function handle(): void
    {
        $now = Carbon::now();
        $todayStr = $now->toDateString();           // e.g. 2026-09-17
        $oneHourAgo = $now->copy()->subHour()->format('H:i:s');  // 1 hour ago
        $currentHMS = $now->format('H:i:s');                      // current time

        // Fetch drivers whose payment_time is within the past 1 hour (or right now)
        $dueDrivers = User::where('role', 'driver')
            ->whereNotNull('payment_time')
            ->whereRaw("TIME_FORMAT(payment_time, '%H:%i:%s') BETWEEN ? AND ?", [$oneHourAgo, $currentHMS])
            ->get();

        if ($dueDrivers->isEmpty()) {
            return;
        }

        $fcm = new FcmNotificationService();

        foreach ($dueDrivers as $driver) {
            // Check if driver already submitted a payment today
            $paid = Payment::where('driver_id', $driver->id)
                ->where('payment_date', $todayStr)
                ->exists();

            if ($paid) {
                continue;
            }

            // Check if driver was already notified today (avoid duplicate notifications)
            $alreadyNotified = Notification::where('user_id', $driver->id)
                ->where('type', 'missed_payment')
                ->whereDate('created_at', $todayStr)
                ->exists();

            if ($alreadyNotified) {
                continue;
            }

            $now = now();

            // Notify driver
            $driverTitle = 'Payment Due';
            $driverBody = "You haven't submitted today's payment yet. Please do it now.";
            $driverSent = $fcm->sendToUser($driver, $driverTitle, $driverBody, ['type' => 'missed_payment']);

            if ($driverSent) {
                Notification::create([
                    'user_id' => $driver->id,
                    'type'    => 'missed_payment',
                    'title'   => $driverTitle,
                    'body'    => $driverBody,
                    'data'    => ['type' => 'missed_payment'],
                ]);
            }

            // Notify their company
            if ($driver->company_id) {
                $company = User::find($driver->company_id);
                if ($company) {
                    $companyTitle = 'Driver Payment Missed';
                    $companyBody = "{$driver->name} has not submitted today's payment.";
                    $companySent = $fcm->sendToUser(
                        $company,
                        $companyTitle,
                        $companyBody,
                        ['type' => 'missed_payment', 'driver_id' => (string) $driver->id]
                    );

                    if ($companySent) {
                        Notification::create([
                            'user_id' => $company->id,
                            'type'    => 'missed_payment',
                            'title'   => $companyTitle,
                            'body'    => $companyBody,
                            'data'    => ['type' => 'missed_payment', 'driver_id' => (string) $driver->id],
                        ]);
                    }
                }
            }

            Log::info("CheckMissedPayments: Was run for driver #{$driver->id} ({$driver->name}) and company.");
        }
    }
}