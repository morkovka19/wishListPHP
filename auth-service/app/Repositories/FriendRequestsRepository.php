<?php

namespace App\Repositories;

use App\Models\FriendRequest;
use App\Models\User;
use App\Repositories\Interfaces\FriendRequestsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\RequestStatusEnum;

class FriendRequestsRepository implements FriendRequestsRepositoryInterface
{
    public function all(User $user)
    {
        return FriendRequest::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->get();
    }

    public function getIncomingRequests(User $user): Collection
    {
        $proposals = FriendRequest::where('receiver_id', $user->id)->where('status', RequestStatusEnum::Sended)->get();
        $proposals = User::whereIn('id', $proposals->pluck('sender_id'))->get();
        return $proposals;
    }

    public function getOutcomingRequests(User $user): Collection
    {
        $requests = FriendRequest::where('sender_id', $user->id)->where('status', RequestStatusEnum::Sended)->get();
        $requests = User::whereIn('id', $requests->pluck('receiver_id'))->get();
        return $requests;
    }
    public function getPendingRequsts(User $user)
    {
        $incomingRequests = $this->getIncomingRequests($user);
        $pendingRequests = $incomingRequests->where('status',  RequestStatusEnum::Sended);
        return $pendingRequests;
    }
    public function getAcceptedRequest(User $user)
    {
        $incomingRequests = $this->getIncomingRequests($user);
        $acceptedRequests = $incomingRequests->where('status', RequestStatusEnum::Accepted);
        return $acceptedRequests;
    }
    public function getRejectedRequest(User $user)
    {
        $incomingRequests = $this->getIncomingRequests($user);
        $rejectedRequests = $incomingRequests->where('status', RequestStatusEnum::Rejected);
        return $rejectedRequests;
    }
    public function getFriendList(User $user)
    {
        $allAcceptedRequests = $this->all($user)->where('status', RequestStatusEnum::Accepted);

        $acceptedSenders = $allAcceptedRequests->where('sender_id', $user->id)->where('status', RequestStatusEnum::Accepted)->pluck('receiver_id');
        $acceptedReceivers = $allAcceptedRequests->where('receiver_id', $user->id)->where('status', RequestStatusEnum::Accepted)->pluck('sender_id');
        $friendList = User::whereIn('id', $acceptedSenders->merge($acceptedReceivers))->get();

        return response()->json($friendList);
    }
}
