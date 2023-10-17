<?php

namespace App\Http\Controllers;

use App\Services\AnimevostApi;
use App\Http\Resources\AnimeRessource;
use App\Http\Resources\EpisodeRessource;
use App\Http\Resources\SearchRessource;

class Anime3Controller extends Controller
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new AnimevostApi();
    }

    public function playlist($id)
    {
        try {
            $apiResponse = $this->apiService->searchById($id);
            return EpisodeRessource::collection($apiResponse);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function search($name)
    {
        try {
            $apiResponse = $this->apiService->searchByName($name);
            return SearchRessource::collection($apiResponse['data']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function last()
    {
        try {
            $apiResponse = $this->apiService->last();
            dd($apiResponse);
            // return SearchRessource::collection($apiResponse['data']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function scrape()
    {
        try {
            $apiResponse = $this->apiService->scrapeAndSaveDataToFile();
            // dd($apiResponse);
            // return SearchRessource::collection($apiResponse['data']);
            return $apiResponse;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function info($id)
    {
        try {
            $apiResponse = $this->apiService->getInfoById($id);
            $data = $apiResponse['data'][0];
            dd($data);
            // return new AnimeRessource($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
