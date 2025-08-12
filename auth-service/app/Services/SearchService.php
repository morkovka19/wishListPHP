<?php
namespace App\Services;

use App\Services\Interfaces\SearchServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class SearchService implements SearchServiceInterface{
    public function getUsersByName(string $name){
        $currentUserId = auth()->user()->id;
        
        $usersQuery = User::whereRaw("LOWER(name) LIKE '%" . strtolower($name) . "%'")
        ->where('id', '!=', $currentUserId);
        return $usersQuery;
    }

    public function getUserById($id)
    {
        try {
            // Использование метода findOrFail для поиска пользователя
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }


}