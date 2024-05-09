<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Interfaces\SearchServiceInterface;


class SearchController extends Controller
{
    private $searchService;
    
    public function __construct(SearchServiceInterface $searchServiceInterface)
    {
        $this->searchService = $searchServiceInterface; 
        $this->middleware('auth:api');
    }
    public function findByName(Request $request){
        
        
        $data = $request->validate([
            'page_number' => 'required|integer|min:1',
            'page_size' => 'required|integer|min:1|max:100',
            'sort_value' => 'required|in:name',
            'sort_direction' => 'required|in:asc,desc',
            
            'name' => 'required|string|min:1'
        ]);

        $pageNumber = $data['page_number'];
        $pageSize = $data['page_size'];
        $sortValue = $data['sort_value'];
        $sortDirection = $data['sort_direction'];
        
        $name = $data['name'];
         
        $usersQuery = $this->searchService->getUsersByName($name);

        $users = $usersQuery->orderBy($sortValue, $sortDirection)->paginate($pageSize, ['*'], 'page', $pageNumber);

        if($users->isEmpty()){
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($users);

    }
}
