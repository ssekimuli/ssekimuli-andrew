<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\ScrapeProfileJob;
use App\Models\Profile;


// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');

//High-traffic profiles (Over 100k likes) every 24 hours
Schedule::call(function () {
    Profile::where('likes_count', '>=', 100000)->chunk(100, function ($profiles) {
        foreach ($profiles as $profile) {
            ScrapeProfileJob::dispatch($profile->username);
        }
    });
})->everySecond();

//Standard profiles every 72 hours
Schedule::call(function () {
    Profile::where('likes_count', '<', 100000)
        ->where('last_scraped_at', '<=', now()->subDays(3))
        ->chunk(100, function ($profiles) {
            foreach ($profiles as $profile) {
                ScrapeProfileJob::dispatch($profile->username);
            }
        });
})->daily();
