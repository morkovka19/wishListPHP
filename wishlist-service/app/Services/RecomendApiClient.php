<?php

namespace App\Services;

use GuzzleHttp\Client;
use function Webmozart\Assert\Tests\StaticAnalysis\integer;

class RecomendApiClient
{
    public function GetTagById(int $tagId): array
    {
        $host = env('RECOM_URL');
        $url = "api/tags/{$tagId}";

        $client = new Client();
        $response = $client->get($host . '/' . $url)
            ->getBody()
            ->getContents();
        $result = json_decode($response, true);
        return [
            'id' => $result['id'],
            'name' => $result['name']
        ];
    }

    public function GetTagList()
    {
        $host = env('RECOM_URL');

        $url = "api/tags?page_number=1&page_size=25000&sort_value=name";

        $client = new Client();
        $response = $client->get($host . '/' . $url)
            ->getBody()
            ->getContents();
        $responseData = json_decode($response);
        return $responseData->data;
    }
}
