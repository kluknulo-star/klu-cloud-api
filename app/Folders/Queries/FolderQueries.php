<?php

namespace App\Folders\Queries;

use App\Common\DTOs\PagingDTO;
use App\Folders\Models\Folder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FolderQueries
{
    public function getFoldersByUserId(int $userId, PagingDTO $paging): LengthAwarePaginator
    {
        return Folder::query()
            ->with(['files'])
            ->where('user_id', $userId)
            ->paginate(perPage: $paging->perPage, page: $paging->page);
    }

//    public function createRootFolder(int $user_id) : Builder|Model
//    {
//        return Folder::query()
//            ->firstOrCreate([
//                'title' => null,
//                'user_id' => $user_id,
//            ]);
//    }

//    public function createUserFolder(string $folderTitile, int $user_id) : Builder|Model
//    {
//        return Folder::query()
//            ->firstOrCreate([
//                'title' => $folderTitile,
//                'user_id' => $user_id,
//            ]);
//    }

    public function findFolderByTitle(string $name, int $userId) : ?Folder
    {
        return Folder::query()
            ->where('name', $name)
            ->where('user_id', $userId)
            ->first();
    }
}