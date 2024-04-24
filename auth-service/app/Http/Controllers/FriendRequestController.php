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
        //get all incoming requests
        $getIncomingRequests = $this->friendRequestsRepository->getIncomingRequests(auth()->user());

        //return filtered requests
        return response()->json($getIncomingRequests);
    }

    public function requests(Request $request)
    {
        //get all incoming requests
        $incomingRequests = $this->friendRequestsRepository->getOutcomingRequests(auth()->user());

        //return incoming requests
        return response()->json($incomingRequests);
    }
    public function list(Request $request)
    {
        //dd($this->friendRequestsRepository->all(auth()->user()));
        //get all incoming requests
        $friendList = $this->friendRequestsRepository->getFriendList(auth()->user());
        //return incoming requests
        return response()->json($friendList);
    }
    public function send(Request $request)
    {
        return $this->friendService->send(auth()->user(), $request->name);
    }
    public function accept(Request $request)
    {
        return $this->friendService->acceptFriend(auth()->user(), $request->name);
    }

    public function reject(Request $request)
    {
        return $this->friendService->rejectFriend(auth()->user(), $request->name);
    }
    
    public function delete(Request $request)
    {
        return $this->friendService->deleteFriend(auth()->user(), $request->name);
    }


}
