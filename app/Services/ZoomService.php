<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ZoomService
{
    protected $client;
    protected $clientId;
    protected $clientSecret;
    protected $accountId;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->clientId = env('ZOOM_CLIENT_ID');
        $this->clientSecret = env('ZOOM_CLIENT_SECRET');
        $this->accountId = env('ZOOM_ACCOUNT_ID');
        $this->baseUrl = env('ZOOM_BASE_URL');
    }

    public function getAccessToken()
    {
        $clientId = env('ZOOM_CLIENT_ID');
        $clientSecret = env('ZOOM_CLIENT_SECRET');
        $accountId = env('ZOOM_ACCOUNT_ID');

        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => $accountId,
            ]);

        if ($response->failed()) {
            throw new \Exception('Failed to obtain Zoom access token: ' . $response->body());
        }

        return $response->json()['access_token'];
    }

    public function createMeeting($topic, $startTime, $duration = 60)
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->post("{$this->baseUrl}/users/me/meetings", [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'topic' => $topic,
                'type' => 2,
                'start_time' => $startTime,
                'duration' => $duration,
                'timezone' => 'Africa/Cairo',
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'waiting_room' => false,
                ],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
