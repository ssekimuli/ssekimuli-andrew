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
        $scraper = new ScraperService();
        try {
           $data = $scraper->fetchProfileData($username=1);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to scrape profile: ' . $e->getMessage()], 500); 
        }
    }
}
