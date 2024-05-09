<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request){
        $jsonPath = storage_path('app\goods.json');

        $jsonData = file_get_contents($jsonPath);
        
        // Преобразуем строку в нужную кодировку (например, в UTF-8)
        //$jsonData = mb_convert_encoding($jsonData, 'CP1251', 'UTF-8');

        $dataArray = json_decode($jsonData, false);
        echo $dataArray;

        dd($jsonData);
    }
}
