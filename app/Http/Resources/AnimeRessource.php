<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimeRessource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    // public static $wrap = 'tags';



    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // public function toArray(Request $request): array
    // {
    //     return [
    //         'title' => $this->title,
    //         'description' => $this->description,
    //         'year' => $this->year,
    //         'image' => $this->image,
    //         'director' => $this->director,
    //         'series' => $this->series,
    //
    //
    //         $formattedData = [];
    //     foreach ($data as $key => $value) {
    //         $formattedData[] = [
    //             'episode' => $key,
    //             'url' => "example.com/{$value}"
    //         ];
    //
    //
    //     ];
    // }
    //
    //
    public function toArray($request): array
    {
        $seriesString = $this->resource->series;

        // Remove single quotes and spaces from the string
        $seriesString = str_replace("'", "", $seriesString);
        $seriesString = str_replace(" ", "", $seriesString);

        // Split the string into key-value pairs
        $keyValuePairs = explode(",", $seriesString);

        // Initialize an empty array to store the formatted data
        $formattedData = [];

        // Loop through the key-value pairs and create the associative array
        foreach ($keyValuePairs as $pair) {
            list($key, $value) = explode(":", $pair);
            $formattedData[trim($key)] = trim($value);
        }

        // $seriesData = json_decode($this->resource->series, true);
        // dd($formattedData);
        $seriesData = $formattedData;

        $formattedData = [];
        foreach ($seriesData as $key => $value) {
            $formattedData[] = [
                'url' => "http://video.aniland.org/720/{$value}.mp4"
            ];
        }

        return [
            'title' => $this->title,
            'description' => $this->description,
            'year' => $this->year,
            'image' => $this->image,
            'director' => $this->director,
            'series' => $formattedData // Add the formatted episode data here
        ];
    }
}
