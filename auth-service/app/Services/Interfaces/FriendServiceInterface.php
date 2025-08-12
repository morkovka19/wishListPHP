<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface FriendServiceInterface
{
    /**
     * send friend request
     */
    public function send(string $receiverName);
     
    /**
     * accept friend request by sender name
     */
    public function acceptFriend(string $name);
    
    /**
     * reject friend request
     */
    public function rejectFriend(string $name);
    
    /**
     * delete friend request
     */
    public function deleteFriend(string $name);
    
}