<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface FriendServiceInterface
{
    /**
     * sendF friend request
     */
    public function send(User $user, string $name);
     
    /**
     * accept friend request
     */
    public function acceptFriend(User $user, string $name);
    
    /**
     * reject friend request
     */
    public function rejectFriend(User $user, string $name);
    
    /**
     * delete friend request
     */
    public function deleteFriend(User $user, string $id);
    
}