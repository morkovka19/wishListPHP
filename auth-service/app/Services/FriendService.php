<?php
namespace App\Services;
use App\Services\Interfaces\FriendServiceInterface;
use App\Repositories\Interfaces\FriendRequestsRepositoryInterface;
use App\Enums\RequestStatusEnum;
use App\Models\FriendRequest;
use App\Models\User;

class FriendService implements FriendServiceInterface
{

    private $friendRequestsRepository;

    public function __construct(FriendRequestsRepositoryInterface $friendRequestsRepositoryInterface)
    {
        $this->friendRequestsRepository = $friendRequestsRepositoryInterface;
    }
    public function send(User $user, string $name)
    {
        $id = (User::where('name', $name)->first())->id;

        $friendRequest = FriendRequest::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $id,
            'status' => 'sended'
        ]);
        return response()->json($user);
    }
    public function acceptFriend(User $user, string $name)
    {
        //dd(User::where('name', $name)->first()->id);
        $id = (User::where('name', $name)->first())->id;
        $this -> friendRequestsRepository
                ->getIncomingRequests($user)
                ->where('sender_id', $id)
                ->toQuery()
                ->update(['status'=> RequestStatusEnum::Accepted]);
        return response()->json($user);
    }
    public function rejectFriend(User $user, string $name)
    {
        $id = (User::where('name', $name)->first())->id;
        $this -> friendRequestsRepository
                ->getIncomingRequests($user)
                ->where('sender_id', $id)
                ->toQuery()
                ->update(['status'=> RequestStatusEnum::Rejected]);
        return response()->json($user);

    }
    public function deleteFriend(User $user, string $name)
    {
        $id = (User::where('name', $name)->first())->id;
        $this -> friendRequestsRepository
                ->getIncomingRequests($user)
                ->where('sender_id', $id)
                ->toQuery()
                ->delete();
        return response()->json($user);
    }
}
