<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface FriendRequestsRepositoryInterface
{
    /**
     * Get all friend requests by user id
     */
    public function all(int $id);
    
    /**
     * Find incoming friend requests by user id
     * 
     * @param int $id
     * 
     */
    public function getIncomingRequests(int $id);
    
    /**
     * Find outcoming friend requests by user id
     * 
     * @param int $id
     * 
     */
    public function getOutcomingRequests(int $id);

    /**
     * Get friend list by User
     * 
     * @param int $id
     */
    public function getFriendList(int $id);

}
