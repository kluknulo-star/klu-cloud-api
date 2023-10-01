<?php

namespace App\Folders\Queries;

use App\Common\DTOs\PagingDTO;
use App\Folders\Models\Folder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FolderQueries
{
    public function getFoldersByUserId(int $userId, PagingDTO $paging): LengthAwarePaginator
    {
        return Folder::query()
            ->with(['files'])
            ->where('user_id', $userId)
            ->paginate(perPage: $paging->perPage, page: $paging->page);
    }
}