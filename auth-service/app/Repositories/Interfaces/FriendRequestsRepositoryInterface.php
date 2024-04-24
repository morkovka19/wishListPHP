<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface FriendRequestsRepositoryInterface
{
    /**
     * Get all friend requests by User
     */
    public function all(User $user);
    
    /**
     * Find incoming friend requests by User
     * 
     * @param User $user
     * 
     */
    public function getIncomingRequests(User $user);
    
    /**
     * Find outcoming friend requests by User
     * 
     * @param User $user
     * 
     */
    public function getOutcomingRequests(User $user);

    /**
     * Get friend requests by User which are pending for acception or rejection
     * 
     * @param User $user
     * 
     */
    public function getPendingRequsts(User $user);

    /**
     * Get accepted friend requests by User
     * 
     * @param User $user
     */
    public function getAcceptedRequest(User $user);

    /**
     * Get accepted friend requests by User
     * 
     * @param User $user
     */
    public function getRejectedRequest(User $user);

    /**
     * Get friend list by User
     * 
     * @param User $user
     */
    public function getFriendList(User $user);

}
