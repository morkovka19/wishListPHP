<?php

namespace App\Services\Interfaces;

interface SearchServiceInterface{
    
    public function getUsersByName(string $name);
    
    public function getUserById(int $id);
}