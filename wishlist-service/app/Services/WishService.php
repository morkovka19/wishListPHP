<?php

namespace App\Services;

use App\Models\WishTable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class WishService
{
    protected WishTable $table;

    protected RecomendApiClient $recomendApiClient;

    public function __construct(WishTable $table, RecomendApiClient $apiClient)
    {
        $this->table = $table;
        $this->recomendApiClient = $apiClient;
    }

    public function create($data): Model|Builder
    {
        return $this->table->create($data);
    }

    public function getById(int $id): Model|Collection|Builder|array|null
    {
        $wish = $this->table->findById($id);

        if(!$wish['tag_id'])
        {
            /// TODO добавить кэщирование кэширование в redis
            $tag = $this->recomendApiClient->GetTagById($wish['tag_id']);
            return [
                'id' => $wish['id'],
                'name' => $wish['name'],
                'description' => $wish['description'],
                'example_url' => $wish['example_url'],
                'priority' => $wish['priority'],
                'user_id' => $wish['user_id'],
                'tag' => [
                    'id' => $tag['id'],
                    'name' => $tag['name'],
                    'description' => $tag['description'],
                ],
            ];
        }

        return [
            'id' => $wish['id'],
            'name' => $wish['name'],
            'description' => $wish['description'],
            'example_url' => $wish['example_url'],
            'priority' => $wish['priority'],
            'user_id' => $wish['user_id'],
            'tag' => null
        ];
    }

    public function update(int $id,int $userId, $data): Model|Collection|Builder|bool|JsonResponse|array
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

    public function delete(int $id, int $userId): Model|Collection|Builder|JsonResponse|array|null
    {
        $wish = $this->table->findById($id);

        if($wish['user_id'] !== $userId)
        {
            return response()->json(['error' => 'Cannot delete wish'], 403);
        }

        $wish->delete();

        return $wish;
    }

    public function list($userId, $data): array
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
        $results = $query->paginate($pageSize, ['*'], 'page', $pageNumber);

        $tags = $this->recomendApiClient->GetTagList();
        ///TODO кэширование + переработка

        $response = [];
        foreach ($results as $result){
            if(!$result["tag_id"]){
                $model = [
                    'id' => $result['id'],
                    'name' => $result['name'],
                    'description' => $result['description'],
                    'example_url' => $result['example_url'],
                    'priority' => $result['priority'],
                    'user_id' => $result['user_id'],
                    'tag' => null
                ];
                $response.add($model);
                continue;
            }

            $tag = $tags[$result['tag_id']];
            $model = [
                'id' => $result['id'],
                'name' => $result['name'],
                'description' => $result['description'],
                'example_url' => $result['example_url'],
                'priority' => $result['priority'],
                'user_id' => $result['user_id'],
                'tag' => [
                    'id' => $tag['id'],
                    'name' => $tag['name'],
                    'description' => $tag['description'],
                ],
            ];

            $response.add($model);
        }
        return $response;
    }
}
