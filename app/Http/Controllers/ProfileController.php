<?php

namespace App\Http\Controllers;

use App\Jobs\ScrapeProfileJob;
use App\Models\Profile;
use App\Services\ScraperService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function search(Request $request)
{
    $query = $request->input('q');
    
    $results = Profile::search($query)->paginate(20);

    return response()->json($results);
    
}

    public function scrape($username)
    {
        $scraper = new ScraperService();
        try {
            //dispatch job to scrape profile
            ScrapeProfileJob::dispatch($username=1);
                return response()->json(['message' => "Scraping job for {$username} has been dispatched."]);
        //    $data = $scraper->fetchProfileData($username=1);
        //     return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to scrape profile: ' . $e->getMessage()], 500); 
        }
    }
}
