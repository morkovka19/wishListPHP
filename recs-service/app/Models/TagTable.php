<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagTable extends Model
{
    protected $table = 'tags';

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

    public function getById($id)
    {
        return self::query()->find($id);
    }
}
