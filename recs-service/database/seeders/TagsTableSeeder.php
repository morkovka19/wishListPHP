<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Получаем путь к JSON файлу
        $jsonPath = storage_path('app/tags.json');

        // Считываем данные из JSON файла
        $jsonData = file_get_contents($jsonPath);

        // Декодируем JSON строку в массив PHP
        $dataArray = json_decode($jsonData, true);

        // Извлекаем из массива данные о тегах
        $tags = $dataArray['tags'];

        // Вставляем данные о тегах в таблицу tags
        foreach ($tags as $id => $name) {
            DB::table('tags')->insert([
                'id' => $id,
                'name' => $name,
            ]);
        }
    }
}
