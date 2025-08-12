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
    public function send(string $receiverName)
    {
        $reciever_id = (User::where('name', $receiverName)->first())->id;

        FriendRequest::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $reciever_id,
            'status' => 'sended'
        ]);
        return response()->json(['status'=>'ok']);
    }
    public function acceptFriend(string $name)
    {
        //dd(User::where('name', $name)->first()->id);
        $id = (User::where('name', $name)->first())->id;
        $this -> friendRequestsRepository
                ->getIncomingRequests(auth()->user()->id)
                ->where('sender_id', $id)
                ->toQuery()
                ->update(['status'=> RequestStatusEnum::Accepted]);
        return response()->json(['status'=>'ok']);


    }
    public function rejectFriend(string $name)
    {
        $id = (User::where('name', $name)->first())->id;
        $this -> friendRequestsRepository
                ->getIncomingRequests($id)
                ->where('sender_id', $id)
                ->toQuery()
                ->update(['status'=> RequestStatusEnum::Rejected]);
        return response()->json(['status'=>'ok']);

    }
    public function deleteFriend(string $name)
    {   $id = (User::where('name', $name)->first())->id;
        $this -> friendRequestsRepository
                ->all(auth()->user()->id)
                ->where('sender_id', auth()->user()->id)
                ->where('receiver_id', $id)
                ->orWhere('receiver_id', auth()->user()->id)
                ->where('sender_id', $id)
                ->toQuery()
                ->delete();
        return response()->json(['status'=>'ok']);
    }
}
