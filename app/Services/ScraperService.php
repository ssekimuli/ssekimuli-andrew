<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;
use RuntimeException;

class ScraperService
{
    /**
     * Scrape profile data from the internal API.
     */
   public function fetchProfileData(string $username=1): array
{
    // $url = config('app.scraping_api_url') . "/users/{$username}";
    $url = config('app.scraping_api_url') . "/{$username}";

    $response = Http::timeout(10)
        ->connectTimeout(5)
        ->retry(3, 1000)
        ->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...',
            'Accept'     => 'application/json, text/plain, */*',
            'app-token'  => 'Y70p_67u_986_56', 
        ])
        ->get($url);

    if ($response->failed()) {
        throw new \RuntimeException(
            "Internal API Error: {$username} returned " . $response->status()
        );
    }

    $data = $response->json();

    return [
        'name'  => $data['username'] ?? $username,
        'bio'   => $data['username'].' - '.$data['email'].' - '.$data['phone'] ?? '', 
        'likes' => (int) ($data['__v'] ?? 0),
        // 'raw'   => $data,
    ];
}
}
