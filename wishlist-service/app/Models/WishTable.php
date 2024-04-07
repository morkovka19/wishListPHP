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
        'priority',
        'user_id'
    ];

    protected $casts = [
        'tag_id' => 'integer'
    ];

    public function create($data)
    {
        return static::query()->create($data);
    }

    public function findById(int $id)
    {
        return static::query()->findOrFail($id);
    }

    public function updateWish($id, $data)
    {
        $wish = self::query()->findOrFail($id);

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
}
