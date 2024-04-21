<?php

namespace App\Services;

use GuzzleHttp\Client;

class RecomendApiClient
{
    public function GetTagById(int $tagId)
    {
        $host = env('RECOM_URL');
        $url = "tags/{$tagId}";

        $client = new Client();
        $response = $client->get($host . '/' . $url)
            ->getBody()
            ->getContents();
        return json_decode($response, true);
    }

    public function GetTagList()
    {
        $host = env('RECOM_URL');
        $url = "tags";

        $client = new Client();
        $response = $client->get($host . '/' . $url)
            ->getBody()
            ->getContents();
        return json_decode($response, true);
    }
}
