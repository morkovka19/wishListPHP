<?php

namespace Tests\Unit;

use App\Models\WishTable;
use App\Services\RecomendApiClient;
use App\Services\WishService;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class WishServiceTests extends TestCase
{
    public function testGetByIdWithoutTag()
    {
        $wishTableMock = Mockery::mock(WishTable::class);

        $wishTableMock->shouldReceive('findById')
            ->with(1)
            ->andReturn([
                'id' => 1,
                'name' => 'Test wish',
                'description' => 'Test description',
                'example_url' => 'https://example.com',
                'priority' => 1,
                'user_id' => 1,
                'tag_id' => null,
            ]);

        $wishService = new WishService($wishTableMock, new RecomendApiClient());

        $result = $wishService->getById(1);

        $this->assertEquals([
            'id' => 1,
            'name' => 'Test wish',
            'description' => 'Test description',
            'example_url' => 'https://example.com',
            'priority' => 1,
            'user_id' => 1,
            'tag' => null,
        ], $result);
    }

    public function testGetByIdWithTag()
    {
        $wishTableMock = Mockery::mock(WishTable::class);

        $wishTableMock->shouldReceive('findById')
            ->with(1)
            ->andReturn([
                'id' => 1,
                'name' => 'Test wish',
                'description' => 'Test description',
                'example_url' => 'https://example.com',
                'priority' => 1,
                'user_id' => 1,
                'tag_id' => 1,
            ]);

        $recomendApiClientMock = Mockery::mock(RecomendApiClient::class);

        $recomendApiClientMock->shouldReceive('GetTagById')
            ->with(1)
            ->andReturn([
                'id' => 1,
                'name' => 'Test tag',
            ]);

        $wishService = new WishService($wishTableMock, $recomendApiClientMock);

        $result = $wishService->getById(1);

        $this->assertEquals([
            'id' => 1,
            'name' => 'Test wish',
            'description' => 'Test description',
            'example_url' => 'https://example.com',
            'priority' => 1,
            'user_id' => 1,
            'tag' => [
                'id' => 1,
                'name' => 'Test tag',
            ],
        ], $result);
    }

    public function testListWithoutFilters()
    {
        $wishTableMock = Mockery::mock(WishTable::class);

        $wishTableMock->shouldReceive('paginate')
            ->with(10, ['*'], 'page', 1)
            ->andReturn(new LengthAwarePaginator([
                (object) [
                    'id' => 1,
                    'name' => 'Test wish 1',
                    'description' => 'Test description 1',
                    'example_url' => 'https://example.com/1',
                    'priority' => 1,
                    'user_id' => 1,
                    'tag_id' => 1,
                ],
                (object) [
                    'id' => 2,
                    'name' => 'Test wish 2',
                    'description' => 'Test description 2',
                    'example_url' => 'https://example.com/2',
                    'priority' => 2,
                    'user_id' => 1,
                    'tag_id' => null,
                ],
            ], 2, 2));

        $recomendApiClientMock = Mockery::mock(RecomendApiClient::class);

        $recomendApiClientMock->shouldReceive('GetTagList')
            ->andReturn([
                (object) ['id' => 1, 'name' => 'Test tag 1'],
                (object) ['id' => 2, 'name' => 'Test tag 2'],
            ]);

        $wishService = new WishService($wishTableMock, $recomendApiClientMock);

        $result = $wishService->list(1, []);

        $expected = [
            [
                'id' => 5,
                'name' => 'Test wish',
                'description' => 'This is a test wish',
                'example_url' => 'https://example.com',
                'priority' => 1,
                'user_id' => 1,
                'tag_id' => 2,
            ],
            [
                'id' => 6,
                'name' => 'Test wish',
                'description' => 'This is a test wish',
                'example_url' => 'https://example.com',
                'priority' => 2,
                'user_id' => 1,
                'tag_id' => null,
            ],
            [
                'id' => 7,
                'name' => 'Test wish',
                'description' => 'This is a test wish',
                'example_url' => 'https://example.com',
                'priority' => 3,
                'user_id' => 1,
                'tag_id' => null,
            ],
        ];

        $this->assertEquals($expected[0], $result[0]);
        $this->assertEquals($expected[1], $result[1]);
    }

}
