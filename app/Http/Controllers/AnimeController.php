<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnimeRessource;
use App\Http\Resources\AnimeCollection;
use App\Http\Resources\EpisodeRessource;
use App\Models\Anime;
use App\Services\AnimevostApi;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new AnimevostApi();
    }

    public function index()
    {
        return AnimeRessource::collection(Anime::paginate());
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('title');
        $animes = Anime::where('title', 'like', '%' . $searchTerm . '%')->get();
        return $animes;
    }

    public function playlist($id)
    {
        try {
            $apiResponse = $this->apiService->searchById($id);
            // return EpisodeRessource::collection($apiResponse);
            return $apiResponse;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
