<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

class FcmNotificationService
{
    protected string $projectId;
    protected string $serviceAccountPath;

    public function __construct()
    {
        $this->projectId = config('services.firebase.project_id') ?? '';
        $this->serviceAccountPath = base_path(config('services.firebase.service_account') ?? '');
    }

    /**
     * Get an OAuth2 access token from the service account credentials.
     */
    protected function getAccessToken(): ?string
    {
        try {
            $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
            $credentials = new ServiceAccountCredentials($scopes, $this->serviceAccountPath);
            $token = $credentials->fetchAuthToken();
            return $token['access_token'] ?? null;
        } catch (\Throwable $e) {
            Log::error('FCM: Failed to get access token: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send a push notification to one or more FCM tokens.
     */
    public function sendToTokens(array $tokens, string $title, string $body, array $data = []): bool
    {
        $tokens = array_filter($tokens, fn($t) => !empty($t));

        if (empty($tokens)) {
            Log::info('FCM: No valid tokens, skipping notification');
            return false;
        }

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return false;
        }

        $successCount = 0;
        foreach ($tokens as $token) {
            $payload = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                    'data' => array_map('strval', $data),
                    'android' => [
                        'priority' => 'high',
                    ],
                    'apns' => [
                        'payload' => [
                            'aps' => ['sound' => 'default'],
                        ],
                    ],
                ],
            ];

            $response = Http::withToken($accessToken)
                ->post("https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send", $payload);

            if ($response->successful()) {
                $successCount++;
            } else {
                Log::error('FCM: Failed to send notification', [
                    'token' => substr($token, 0, 20) . '...',
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
        }

        Log::info("FCM: Sent {$successCount}/" . count($tokens) . " notifications");
        return $successCount > 0;
    }

    /**
     * Send to a single user (looks up their fcm_token).
     */
    public function sendToUser(\App\Models\User $user, string $title, string $body, array $data = []): bool
    {
        if (!$user->fcm_token) {
            Log::info("FCM: User {$user->id} has no FCM token");
            return false;
        }
        return $this->sendToTokens([$user->fcm_token], $title, $body, $data);
    }
}
