<?php

namespace App\Services;

use App\Models\ItemTable;
use Illuminate\Support\Facades\DB;

class RecomendService
{
    protected ItemTable $table;

    public function __construct(ItemTable $table)
    {
        $this->table = $table;
    }

    public function get(int $id)
    {
        $recomend = $this->table->findById($id);
        return $recomend;
    }

    public function list(int $tagId, $data)
    {
        $pageNumber = $data['page_number'];
        $pageSize = $data['page_size'];
        $sortValue = $data['sort_value'];
        $sortDirection = $data['sort_direction'];

        $query = DB::table('items')
            ->where('tag_id', $tagId);

        $query->orderBy($sortValue, $sortDirection);

        return $query->paginate($pageSize, ['*'], 'page', $pageNumber);
    }

}
