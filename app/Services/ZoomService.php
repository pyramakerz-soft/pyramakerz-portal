<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $clientId = 'eoTsATzcQ82hCZFb5lrAMw';
        $clientSecret = 'HpQ5g9uKo02hQYaLp718cf7gNtLIlpg1';
        $accountId = 'Z90-x6MMSOWNZj5en7PEpQ';

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

    

public function createMeeting($topic, $sessionDate, $startTime, $endTime)
{
    $startDateTime = \Carbon\Carbon::parse($sessionDate . ' ' . $startTime);
    $endDateTime = \Carbon\Carbon::parse($sessionDate . ' ' . $endTime);

    $duration = $startDateTime->diffInMinutes($endDateTime);
    $accessToken = $this->getAccessToken();

    if (!$accessToken) {
        throw new \Exception('Zoom access token is missing.');
    }

    $response = Http::withHeaders([
        'Authorization' => "Bearer $accessToken",
        'Content-Type'  => 'application/json',
    ])->post("https://api.zoom.us/v2/users/me/meetings", [
        'topic'      => $topic,
        'type'       => 2, // Scheduled meeting
        'start_time' => $startDateTime->toIso8601String(),
        'duration'   => $duration,
        'timezone'   => 'Africa/Cairo',
        'settings'   => [
            'host_video'        => true,
            'participant_video' => true,
            'waiting_room'      => false,
        ],
    ]);

    if ($response->failed()) {
        \Log::error('Zoom API error: ' . $response->body());
        throw new \Exception('Failed to create Zoom meeting: ' . $response->body());
    }

    return $response->json();
}

    



}
