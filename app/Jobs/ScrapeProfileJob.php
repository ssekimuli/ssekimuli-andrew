<?php

namespace App\Jobs;
use App\Models\Profile;
use App\Services\ScraperService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ScrapeProfileJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $username)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ScraperService $scraper): void
    {
     $data = $scraper->fetchProfileData($this->username);

        $profile = Profile::updateOrCreate(
            ['username' => $this->username],
            [
                'name' =>  $data['username'] ?? $this->username,
                'bio' => $data['username'].' - '.$data['email'].' - '.$data['phone'] ?? '',
                'likes_count' => (int) ($data['__v'] ?? 0),
                'last_scraped_at' => now(),
            ]
        );


        // $profile->snapshots()->create([
        //     'name' => $data['name'],
        //     'bio' => $data['bio'],
        //     'likes_count' => $data['likes'] ?? 0,
        //     'raw_data' => $data['raw'] ?? [],
        // ]);
    }
}
