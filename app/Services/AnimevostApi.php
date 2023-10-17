<?php

namespace App\Services;

use App\Models\Anime;
use GuzzleHttp\Client;

class AnimevostApi
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.animevost.org/v1/',
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);
    }

    public function searchById($id)
    {
        try {
            $response = $this->client->post('playlist', [
                'form_params' => [
                    'id' => $id,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function searchByName($name)
    {
        try {
            $response = $this->client->post('search', [
                'form_params' => [
                    'name' => $name,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getInfoById($id)
    {
        try {
            $response = $this->client->post('info', [
                'form_params' => [
                    'id' => $id,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function last()
    {
        try {
            $response = $this->client->get('last?page=1&quantity=40');
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function scrapeAndSaveData()
    {
        // $page = 1;
        $quantity = 40;
        $data = [];

        // do {
        //     $response = $this->client->get("last?page=$page&quantity=$quantity");
        //     $body = json_decode($response->getBody(), true);
        //     $data = array_merge($data, $body['data']); // Assuming the API response has a 'data' key containing the actual data
        //
        //     $page++;
        // } while (!empty($body['data'])); // Continue until there is no more data in the response
        //
        for ($page = 1; $page <= 60; $page++) {
            $response = $this->client->get("last?page=$page&quantity=$quantity");
            $body = json_decode($response->getBody(), true);

            // If there is no data in the response, break out of the loop
            if (empty($body['data'])) {
                break;
            }

            $data = array_merge($data, $body['data']); // Assuming the API response has a 'data' key containing the actual data
        }

        // Save the scraped data to the database
        // foreach ($data as $item) {
        //     YourModel::create([
        //         'column_name_1' => $item['field_name_1'], // Replace column_name_1 and field_name_1 with your actual column and field names
        //         'column_name_2' => $item['field_name_2'], // Replace column_name_2 and field_name_2 with your actual column and field names
        //         // ... Repeat this pattern for other columns
        //     ]);
        // }
        // $data = json_decode($response->getBody(), true);
        // return $data;


        // return response()->json(['message' => 'Data scraped and saved successfully']);
    }



    public function scrapeAndSaveDataToFile()
    {
        $page = 1;
        $quantity = 40;
        $data = [];

        // // Scrape data from 10 pages
        for ($page = 1; $page <= 3; $page++) {
            $response = $this->client->get("last?page=$page&quantity=$quantity");
            $body = json_decode($response->getBody(), true);

            // If there is no data in the response, break out of the loop
            if (empty($body['data'])) {
                break;
            }

            $data = array_merge($data, $body['data']); // Assuming the API response has a 'data' key containing the actual data
        }


        // do {
        //     $response = $this->client->get("last?page=$page&quantity=$quantity");
        //     $body = json_decode($response->getBody(), true);
        //
        //     if (empty($body['data'])) {
        //         break;
        //     }
        //
        //     $data = array_merge($data, $body['data']); // Assuming the API response has a 'data' key containing the actual data
        //
        //     $page++;
        // } while (!empty($body['data'])); // Continue until there is no more data in the response


        // Save the scraped data to the database
        foreach ($data as $item) {
            Anime::create([
                'title' => $item['title'], // Replace column_name_1 and field_name_1 with your actual column and field names
                'year' => $item['year'], // Replace column_name_2 and field_name_2 with your actual column and field names
                'description' => $item['description'],
                'image' => $item['urlImagePreview'],
                'director' => $item['director'],
                'series' => $item['series'],
                // ... Repeat this pattern for other columns
            ]);
        }
        $data = json_decode($response->getBody(), true);
        // return $data;



        // Convert data to JSON
        // $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Save data to a file
        // $filePath = storage_path('app/scraped_data.json'); // You can change the file path and name as needed
        // file_put_contents($filePath, $jsonData);

        return response()->json(['message' => 'Data scraped and saved to file successfully']);
    }
}
