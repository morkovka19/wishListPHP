<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function get(int $id): JsonResponse
    {
        $response = $this->tagService->get($id);

        if(!$response)
        {
            return response()->json(['error' => 'Tag with such id does not exist'], 404);
        }

        return response()->json($response);
    }

    public function list(Request $request): JsonResponse
    {
        $data = $request->validate([
            'page_number' => 'required|integer|min:1',
            'page_size' => 'required|integer|min:1',
            'sort_value' => 'required|in:name,description'
        ]);

        $response = $this->tagService->list($data);

        if(!$response){
            return response()->json(['error' => 'Tags not found'], 404);
        }

        return response()->json($response);
    }
}
