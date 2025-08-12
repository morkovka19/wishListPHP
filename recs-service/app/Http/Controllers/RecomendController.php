<?php

namespace App\Http\Controllers;

use App\Services\RecomendApiClient;
use App\Services\RecomendService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecomendController extends Controller
{
    protected RecomendService $recomendateService;

    public function __construct(RecomendService $recomendateService)
    {
        $this->recomendateService = $recomendateService;
    }

    public function get(int $id): JsonResponse
    {
        $response = $this->recomendateService->get($id);

        if(!$response){
            return response()->json(['error' => 'Recommendation with such id does not exist'], 404);
        }

        return response()->json($response);
    }

    public function list(int $tagId, Request $request): JsonResponse
    {
        $data = $request->validate([
            'page_number' => 'required|integer|min:1',
            'page_size' => 'required|integer|min:1|max:100',
            'sort_value' => 'required|in:name,description',
            'sort_direction' => 'required|in:asc,desc'
        ]);

        $response = $this->recomendateService->list($tagId, $data);

        if(!$response){
            return response()->json(['error' => 'Recommendations not exist'], 404);
        }

        return response()->json($response);
    }
}
