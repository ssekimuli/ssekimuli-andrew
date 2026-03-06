<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class ScraperService
{
    /**
     * Scrape profile data from the internal API.
     */
    public function fetchProfileData(string $username): array
    {
        // return [
        //     'name'  => $username,
        //     'bio'   => "Bio for {$username}",
        //     'likes' => rand(0, 1000),
        //     'url'   => config('app.scraping_api_url') . "/{$username}",
        // ];
        $url = config('app.scraping_api_url') . "/{$username}";

        $response = Http::timeout(10)
            ->connectTimeout(5)
            ->retry(3, 1000)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0',
                'Accept'     => 'application/json',
            ])
            ->get($url);

        if ($response->failed()) {
            throw new Exception(
                "Failed to fetch profile from {$url}. Status: " . $response->status()
            );
        }

        $data = $response->json();

        return [
            'name'  => $data['name'] ?? $username,
            'bio'   => $data['bio'] ?? '',
            'likes' => $data['likes_count'] ?? 0,
        ];
    }
}
