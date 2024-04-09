<?php

namespace App\Services;

use App\Models\WishTable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class WishService
{
    protected WishTable $table;

    public function __construct(WishTable $table)
    {
        $this->table = $table;
    }

    public function create($data)
    {
        return $this->table->create($data);
    }

    public function getById(int $id)
    {
        return $this->table->findById($id);
    }

    public function update(int $id,int $userId, $data)
    {
        $wish = $this->table->findById($id);

        if(!$wish)
        {
            return response()->json(['error' => 'Wish with this id does not exist'], 404);
        }

        if($wish['user_id'] !== $userId)
        {
            return response()->json(['error' => 'Can not update wish'], 403);
        }

        return $this->table->updateWish($id, $data);
    }

    public function delete(int $id, int $userId)
    {
        $wish = $this->table->findById($id);

        if($wish['user_id'] !== $userId)
        {
            return response()->json(['error' => 'Cannot delete wish'], 403);
        }

        $wish->delete();

        return $wish;
    }

    public function list($userId, $data): LengthAwarePaginator
    {
        $pageNumber = $data['page_number'] ?? 1;
        $pageSize = $data['page_size'] ?? 10;
        $sortValue = $data['sort_value'] ?? 'created_at';
        $sortDirection = $data['sort_direction'] ?? 'desc';

        $query = DB::table('wishes')
            ->where('user_id', $userId);

        if ($sortValue === 'name') {
            $query->orderBy('name', $sortDirection);
        } elseif ($sortValue === 'priority') {
            $query->orderBy('priority', $sortDirection);
        } else {
            $query->orderBy('created_at', $sortDirection);
        }

        return $query->paginate($pageSize, ['*'], 'page', $pageNumber);
    }

}
