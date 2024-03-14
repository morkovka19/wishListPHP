<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTable extends Model
{
    public static function findItemById($id)
    {
        return self::find($id);
    }

    public static function createItem($data)
    {
        return self::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'example_url' => $data['example_url'],
            'tag_id' => $data['tag_id'],
            'taf_id' => $data['taf_id']
        ]);
    }

    public static function updateItem($id, $data)
    {
        $item = self::find($id);

        if (!$item) {
            return false;
        }

        $item->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'example_url' => $data['example_url'],
            'tag_id' => $data['tag_id'],
            'taf_id' => $data['taf_id']
        ]);

        return $item;
    }

    public static function deleteItem($id)
    {
        $item = self::find($id);

        if (!$item) {
            return false;
        }

        return $item->delete();
    }

    public static function findItemsByTagId($tagId)
    {
        return self::where('tag_id', $tagId)->get();
    }
}
