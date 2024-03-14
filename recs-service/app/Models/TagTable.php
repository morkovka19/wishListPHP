<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagTable extends Model
{
    public static function findTagById($id)
    {
        return self::find($id);
    }

    public static function createTag($data)
    {
        return self::create([
            'name' => $data['name']
        ]);
    }

    public static function updateTag($id, $data)
    {
        $tag = self::find($id);

        if (!$tag) {
            return false;
        }

        $tag->update([
            'name' => $data['name']
        ]);

        return $tag;
    }

    public static function deleteTag($id)
    {
        $tag = self::find($id);

        if (!$tag) {
            return false;
        }

        return $tag->delete();
    }
}
