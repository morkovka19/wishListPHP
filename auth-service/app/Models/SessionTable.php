<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionTable extends Model
{
    protected $table = 'sessions';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createSession($userId, $ipAddress, $userAgent, $payload)
    {
        return self::create([
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'payload' => $payload,
            'last_activity' => now(),
        ]);
    }

    public static function updateSession($id, $userId, $ipAddress, $userAgent, $payload)
    {
        $session = self::find($id);

        if (!$session) {
            return false;
        }

        $session->user_id = $userId;
        $session->ip_address = $ipAddress;
        $session->user_agent = $userAgent;
        $session->payload = $payload;
        $session->last_activity = now();
        $session->save();

        return $session;
    }

    public static function deleteSession($id)
    {
        $session = self::find($id);

        if (!$session) {
            return false;
        }

        return $session->delete();
    }
}
