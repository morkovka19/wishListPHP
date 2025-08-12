<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Interfaces\FriendRequestsRepositoryInterface;
use App\Services\Interfaces\FriendServiceInterface;
use App\Models\FriendRequest;
use App\Models\User;
use App\Enums\RequestStatusEnum;

class FriendRequestController extends Controller
{
    private $friendRequestsRepository;
    private $friendService;
    
    public function __construct(FriendRequestsRepositoryInterface $friendRequestsRepository,
                                FriendServiceInterface $friendService)
    {
        $this->middleware('auth:api');
        $this->friendRequestsRepository = $friendRequestsRepository;
        $this->friendService = $friendService;
    }

    public function proposals(Request $request)
    {
        $data = $request->validate([
            'page_number' => 'required|integer|min:1',
            'page_size' => 'required|integer|min:1|max:100',
            'sort_value' => 'required|in:name',
            'sort_direction' => 'required|in:asc,desc'
        ]);

        $pageNumber = $data['page_number'];
        $pageSize = $data['page_size'];
        $sortValue = $data['sort_value'];
        $sortDirection = $data['sort_direction'];

        //get all incoming requests
        $getIncomingRequests = $this->friendRequestsRepository->getIncomingRequests(auth()->user()->id);
        $getIncomingRequests = $getIncomingRequests->orderBy($sortValue, $sortDirection)
                                    ->paginate($pageSize, ['*'], 'page', $pageNumber);

        //return filtered requests
        return response()->json($getIncomingRequests);
    }

    public function requests(Request $request)
    {
        $data = $request->validate([
            'page_number' => 'required|integer|min:1',
            'page_size' => 'required|integer|min:1|max:100',
            'sort_value' => 'required|in:name',
            'sort_direction' => 'required|in:asc,desc'
        ]);
        
        
        $pageNumber = $data['page_number'];
        $pageSize = $data['page_size'];
        $sortValue = $data['sort_value'];
        $sortDirection = $data['sort_direction'];
        
        //get all outcoming requests
        $outcomingRequests = $this->friendRequestsRepository->getOutcomingRequests(auth()->user()->id);
        $outcomingRequests = $outcomingRequests->orderBy($sortValue, $sortDirection)
                                    ->paginate($pageSize, ['*'], 'page', $pageNumber);
        //return incoming requests
        return response()->json($outcomingRequests);
    }
    
    public function list(Request $request)
    {
        
        //get all incoming requests
        $data = $request->validate([
            'page_number' => 'required|integer|min:1',
            'page_size' => 'required|integer|min:1|max:100',
            'sort_value' => 'required|in:name',
            'sort_direction' => 'required|in:asc,desc'
        ]);
        
        $pageNumber = $data['page_number'];
        $pageSize = $data['page_size'];
        $sortValue = $data['sort_value'];
        $sortDirection = $data['sort_direction'];
        
        $friendList = $this->friendRequestsRepository->getFriendList(auth()->user()->id);
        $friendList = $friendList->orderBy($sortValue, $sortDirection)
                                    ->paginate($pageSize, ['*'], 'page', $pageNumber);
        return response()->json($friendList);
    }
    public function send(Request $request)
    {
        return $this->friendService->send(auth()->user()->id, $request->name);
    }
    public function accept(Request $request)
    {
        return $this->friendService->acceptFriend(auth()->user()->id, $request->name);
    }

    public function reject(Request $request)
    {
        return $this->friendService->rejectFriend(auth()->user()->id, $request->name);
    }
    
    public function delete(Request $request)
    {
        return $this->friendService->deleteFriend($request->name);
    }


}
