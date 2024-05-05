<?php

namespace Database\Seeders;

use App\Models\ItemTable;
use App\Models\TagTable;
use Illuminate\Database\Seeder;
use Illuminate\Tests\Integration\Database\EloquentBelongsToManyTest\Tag;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        TagTable::create([
            'name' => 'Tag 1'
        ]);

        TagTable::create([
            'name' => 'Tag 2',
        ]);

        TagTable::create([
            'name' => 'Tag 3'
        ]);

        for ($i = 1; $i <= 12; $i++) {
            $item = ItemTable::create([
                'name' => 'Item ' . $i,
                'description' => 'Description for Item ' . $i,
                'example_url' => 'https://example.com/item-' . $i,
                'tag_id' => 2,
            ]);
        }

        for ($i = 1; $i <= 12; $i++) {
            $item = ItemTable::create([
                'name' => 'Item ' . $i,
                'description' => 'Description for Item ' . $i,
                'example_url' => 'https://example.com/item-' . $i,
            ]);
        }
    }
}
