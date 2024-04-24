<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Enums\RequestStatusEnum;

class FriendRequest extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     * 
     * @var string[]
     *  
     *    
     */
    
     protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];
    /**
     * The attributes that should be cast.
     * 
     * @var array
     */
    protected $casts = [
        'sender_id' => 'int',
        'receiver_id' => 'int',
        'status' => RequestStatusEnum::class
    ];

    /**
     * Get the user that owns the friend request.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');

    }
    
    /**
     * Get the user that received the friend request.
     */
    public function reciever(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }
    
}
