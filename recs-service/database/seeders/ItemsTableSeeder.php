<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Получаем путь к JSON файлу
        $jsonPath = storage_path('goods.json');
        echo $jsonPath;
        // Считываем данные из JSON файла
        $jsonData = file_get_contents($jsonPath);
        echo $jsonData;
        // Декодируем JSON строку в массив PHP
        $dataArray = json_decode($jsonData, true);

        // Извлекаем из массива данные о тегах
        $goods = $dataArray['goods'];

        // Вставляем данные о тегах в таблицу tags
        foreach ($goods as $good) {
            DB::table('items')->insert([
                'name' => $good['name'],
                'description' => $good['example_url'],
                'example_url' => $good['example_url'],
                'tag_id' => $good['tag_id']
            ]);
        }
    }
}
