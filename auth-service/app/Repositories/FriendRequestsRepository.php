<?php

namespace App\Repositories;

use App\Models\FriendRequest;
use App\Models\User;
use App\Repositories\Interfaces\FriendRequestsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\RequestStatusEnum;

class FriendRequestsRepository implements FriendRequestsRepositoryInterface
{
    public function all(int $id)
    {
        return FriendRequest::where('sender_id', $id)->orWhere('receiver_id', $id)->get();
    }

    public function getIncomingRequests(int $id): Collection
    {
        $proposals = FriendRequest::where('receiver_id', $id)->where('status', RequestStatusEnum::Sended)->get(); 
        $proposals = User::whereIn('id', $proposals->pluck('sender_id'));
        return $proposals;
    }
    
    public function getOutcomingRequests(int $id): Collection
    {
        $requests = FriendRequest::where('sender_id', $id)->where('status', RequestStatusEnum::Sended)->get(); 
        $requests = User::whereIn('id', $requests->pluck('receiver_id'));
        return $requests;
    }
    
    public function getFriendList(int $id)
    {
        $allAcceptedRequests = $this->all($id)->where('status', RequestStatusEnum::Accepted); 
        
        $acceptedSenders = $allAcceptedRequests->where('sender_id', $id)->where('status', RequestStatusEnum::Accepted)->pluck('receiver_id');
        $acceptedReceivers = $allAcceptedRequests->where('receiver_id', $id)->where('status', RequestStatusEnum::Accepted)->pluck('sender_id');
        
        $friendList = User::whereIn('id', $acceptedSenders->merge($acceptedReceivers));
        
        return $friendList;
    }

}