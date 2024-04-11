<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTable extends Model
{
    protected $table = 'items';

    public static function createItem($data)
    {
        return self::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'example_url' => $data['example_url'],
            'tag_id' => $data['tag_id'],
        ]);
    }

    public static function updateItem($id, $data)
    {
        $item = self::query()->find($id);

        if (!$item) {
            return false;
        }

        $item->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'example_url' => $data['example_url'],
            'tag_id' => $data['tag_id'],
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

    public function findById($id)
    {
        return self::query()->find($id);
    }
}
