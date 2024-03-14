<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleTable extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function createRole($name)
    {
        return self::create([
            'name' => $name,
        ]);
    }

    public static function updateRole($id, $name)
    {
        $role = self::find($id);

        if (!$role) {
            return false;
        }

        $role->name = $name;
        $role->save();

        return $role;
    }

    public static function deleteRole($id)
    {
        $role = self::find($id);

        if (!$role) {
            return false;
        }

        return $role->delete();
    }
}
