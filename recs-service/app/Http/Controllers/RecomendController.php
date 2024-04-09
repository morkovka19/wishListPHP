<?php

namespace App\Http\Controllers;

use App\Services\RecomendService;
use Illuminate\Http\Request;

class RecomendController extends Controller
{
    protected RecomendService $recomendateService;

    public function __construct(RecomendService $recomendateService)
    {
        $this->$recomendateService = $recomendateService;
    }

    public function get(int $id)
    {
        $response = $this->recomendateService->get($id);

        if(!$response){
            return response()->json(['error' => 'Recommendation with such id does not exist'], 404);
        }

        return response()->json($response);
    }

    public function list(int $tagId, Request $request)
    {
        $data = $request->validate([
            'page_number' => 'nullable|integer|min:1',
            'page_size' => 'nullable|integer|min:1|max:100',
            'sort_value' => 'nullable|in:name,description'
        ]);

        $response = $this->recomendateService->list($tagId, $data);

        if(!$response){
            return response()->json(['error' => 'Wish not found'], 404);
        }

        return response()->json($response);
    }
}
