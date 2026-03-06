<?php

namespace App\Http\Controllers;

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
        // return response()->json(['message' => "Scraping profile: $username"]);
        $scraper = new ScraperService();
        try {
           return $data = $scraper->fetchProfileData($username);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to scrape profile: ' . $e->getMessage()], 500); 
        }
    }
}
