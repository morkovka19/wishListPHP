<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;

class RecomendApiClient
{
    public function GetTagById(int $tagId): array
    {
        $useRedis = env('USE_REDIS', false);

        $cacheKey = "tag:{$tagId}";
        if($useRedis) {
            $result = Redis::get($cacheKey);
            if ($result != null) {
                return json_decode($result, true);
            }
        }

        $host = env('RECOM_URL');
        $url = "api/tags/{$tagId}";

        $client = new Client();
        $response = $client->get($host . '/' . $url)
            ->getBody()
            ->getContents();
        $result = json_decode($response, true);

        if($useRedis) {
            Redis::set($cacheKey, json_encode($result), 'EX', 3600);
        }

        return [
            'id' => $result['id'],
            'name' => $result['name']
        ];
    }

    public function GetTagList()
    {
        $cacheKey = "tags";
        $useRedis = env('USE_REDIS', false);
        if($useRedis) {
            $result = Redis::get($cacheKey);
            if ($result != null) {
                return json_decode($result);
            }
        }

        $host = env('RECOM_URL');

        $url = "api/tags?page_number=1&page_size=25000&sort_value=name";

        $client = new Client();
        $response = $client->get($host . '/' . $url)
            ->getBody()
            ->getContents();
        $responseData = json_decode($response);

        if($useRedis) {
            Redis::set($cacheKey, json_encode($responseData->data), 'EX', 3600);
        }

        return $responseData->data;
    }
}
