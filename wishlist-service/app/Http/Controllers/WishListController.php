<?php

namespace App\Http\Controllers;

use App\Services\WishService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WishListController extends Controller
{
    protected WishService $wishService;

    public function __construct(WishService $wishService)
    {
        $this->wishService = $wishService;
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'example_url' => 'nullable|url',
            'tag_id' => 'nullable|integer',
            'priority' => 'nullable|integer|min:1',
            'user_id' => 'required|integer|min:1'
        ]);

        $response = $this->wishService->create($data);
        return response()->json($response, 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'example_url' => 'nullable|url',
            'tag_id' => 'nullble|integer',
            'priority' => 'nullble|integer|min:1',
            'user_id' => 'required|integer|min:1'
        ]);

        $user_id = $data['user_id'];

        $response = $this->wishService->update($id, $user_id, $data);
        return response()->json($response);
    }

    public function getList(int $userId ,Request $request): JsonResponse
    {
        $data = $request->validate([
            'page_number' => 'required|integer|min:1',
            'page_size' => 'required|integer|min:1|max:100',
            'sort_value' => 'required|in:name,priority',
            'sort_direction' => 'required|in:asc,desc'
        ]);

        $list = $this->wishService->list($userId, $data);
        return response()->json($list);
    }

    public function delete(int $id, int $userId): Response
    {
        $this->wishService->delete($id, $userId);
        return response()->noContent();
    }

    public function get(int $id): JsonResponse
    {
        $wish = $this->wishService->getById($id);

        if (!$wish) {
            return response()->json(['error' => 'Wish not found'], 404);
        }

        return response()->json($wish);
    }
}
