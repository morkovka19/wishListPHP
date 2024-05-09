<?php
namespace App\Services;

use App\Services\Interfaces\SearchServiceInterface;
use App\Models\User;


class SearchService implements SearchServiceInterface{
    public function getUsersByName(string $name){
        $currentUserId = auth()->user()->id;
        
        $usersQuery = User::whereRaw("LOWER(name) LIKE '%" . strtolower($name) . "%'")
        ->where('id', '!=', $currentUserId);
        return $usersQuery;
    }

}