<?php

namespace App\Http\Controllers;

use App\Services\WishService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WishListController extends Controller
{
    protected WishService $wishService;

    public function __construct(WishService $wishService)
    {
        $this->wishService = $wishService;
    }

    public function create($request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'example_url' => 'nullable|url',
            'tag_id' => 'required|integer',
            'priority' => 'required|integer|min:1',
            'user_id' => 'required|integer'
        ]);

        $response = $this->wishService->create($data);
        return response()->json($response, 201);
    }

    public function update(int $id, $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'example_url' => 'nullable|url',
            'tag_id' => 'required|integer',
            'priority' => 'required|integer|min:1',
            'user_id' => 'required|integer|min:1'
        ]);

        $user_id = $data['user_id'];

        $response = $this->wishService->update($id, $user_id, $data);
        return response()->json($response);
    }

    public function getList(int $userId ,$request): JsonResponse
    {
        $data = $request->validate([
            'page_number' => '',
            'page_size' => '',
            'sort_value' => '',
            'sort_direction' => ''
        ]);

        $list = $this->wishService->list($userId, $data);
        return response()->json($list);
    }

    public function delete(int $id, int $userId): Response
    {
        $this->wishService->delete($id, $userId);
        return response()->noContent();
    }

    public function get(): JsonResponse
    {
        $requestData = request()->validate([
            'id' => 'required|integer|min:1',
        ]);

        $wish = $this->wishService->getById($requestData['id']);

        if (!$wish) {
            return response()->json(['error' => 'Wish not found'], 404);
        }

        return response()->json($wish);
    }
}
