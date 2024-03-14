<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserTable extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'login',
        'password',
        'friends',
        'role_id',
    ];

    protected $casts = [
        'friends' => 'array',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public static function createUser($login, $password, $friends = [], $roleId)
    {
        return self::create([
            'login' => $login,
            'password' => bcrypt($password),
            'friends' => $friends,
            'role_id' => $roleId,
        ]);
    }

    public static function updateUser($id, $login, $password, $friends = [], $roleId)
    {
        $user = self::find($id);

        if (!$user) {
            return false;
        }

        $user->login = $login;
        $user->password = bcrypt($password);
        $user->friends = $friends;
        $user->role_id = $roleId;
        $user->save();

        return $user;
    }

    public static function deleteUser($id)
    {
        $user = self::find($id);

        if (!$user) {
            return false;
        }

        return $user->delete();
    }
}
