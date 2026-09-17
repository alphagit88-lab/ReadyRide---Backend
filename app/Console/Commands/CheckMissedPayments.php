<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Payment;
use App\Services\FcmNotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckMissedPayments extends Command
{
    protected $signature   = 'app:check-missed-payments';
    protected $description = 'Notify drivers and companies if a payment has not been submitted by the due time';

    public function handle(): void
    {
        $now = Carbon::now();
        $todayStr   = $now->toDateString();       // e.g. 2026-09-17
        $currentHM  = $now->format('H:i');        // e.g. 14:30

        // Fetch all drivers who have a payment_time set matching right now (HH:MM)
        $dueDrivers = User::where('role', 'driver')
            ->whereNotNull('payment_time')
            ->whereRaw("TIME_FORMAT(payment_time, '%H:%i') = ?", [$currentHM])
            ->get();

        if ($dueDrivers->isEmpty()) {
            return;
        }

        $fcm = new FcmNotificationService();

        foreach ($dueDrivers as $driver) {
            // Check if driver already submitted a payment today
            $paid = \DB::table('payments')
                ->where('user_id', $driver->id)
                ->where('payment_date', $todayStr)
                ->exists();

            if ($paid) {
                continue;
            }

            // Notify driver
            $fcm->sendToUser(
                $driver,
                '⚠️ Payment Due',
                "You haven't submitted today's payment yet. Please do it now.",
                ['type' => 'missed_payment']
            );

            // Notify their company
            if ($driver->company_id) {
                $company = User::find($driver->company_id);
                if ($company) {
                    $fcm->sendToUser(
                        $company,
                        '⚠️ Driver Payment Missed',
                        "{$driver->name} has not submitted today's payment.",
                        ['type' => 'missed_payment', 'driver_id' => (string) $driver->id]
                    );
                }
            }

            Log::info("CheckMissedPayments: Notified driver #{$driver->id} ({$driver->name}) and company.");
        }
    }
}
