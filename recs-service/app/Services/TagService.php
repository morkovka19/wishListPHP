<?php

namespace App\Services;

use App\Models\TagTable;
use Illuminate\Support\Facades\DB;

class TagService
{
    protected TagTable $table;

    public function __construct(TagTable $table)
    {
        $this->table = $table;
    }

    public function get(int $id)
    {
        $model = $this->table->getById($id);

        if(!$model){
            return response()->json(['error' => 'Tag with this id does not exist '], 404);
        }

        return $model;
    }

    public function list($data)
    {
        $pageNumber = $data['page_number'];
        $pageSize = $data['page_size'];
        $sortValue = $data['sort_value'];

        $query = DB::table('tags');

        $query->orderBy($sortValue);

        return $query->paginate($pageSize, ['*'], 'page', $pageNumber);
    }
}
