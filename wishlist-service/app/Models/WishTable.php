<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WishTable extends Model
{
    protected $table = 'wishes';

    protected $fillable = [
        'name',
        'description',
        'example_url',
        'tag_id',
        'priority'
    ];

    protected $casts = [
        'tag_id' => 'integer'
    ];

    public static function createWish($data)
    {
        return self::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'example_url' => $data['example_url'],
            'tag_id' => $data['tag_id'],
            'priority' => $data['priority'],
        ]);
    }

    public static function updateWish($id, $data)
    {
        $wish = self::find($id);

        if (!$wish) {
            return false;
        }

        $wish->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'example_url' => $data['example_url'],
            'tag_id' => $data['tag_id'],
            'priority' => $data['priority'],
        ]);

        return $wish;
    }

    public static function deleteWish($id)
    {
        $wish = self::find($id);

        if (!$wish) {
            return false;
        }

        return $wish->delete();
    }
}
