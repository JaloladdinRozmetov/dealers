<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CounterConnectService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = env('CONNECT_COUNTER_URL');
        $this->token = env('COUNTER_TOKEN');
    }

    public function fetchMeters($page = 0, $size = 1, $serial = '')
    {
        $url = $this->baseUrl . 'meters';

        $response = Http::withHeaders([
            'Authorization' => $this->token,
            'Content-Type'  => 'application/json',
        ])->get($url, [
            'page' => $page,
            'size' => $size,
            'serial' => $serial,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Error fetching meters: ' . $response->body());
    }
}
