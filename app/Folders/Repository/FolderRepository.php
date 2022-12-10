<?php

namespace App\Folders\Repository;


use App\Folders\Models\Folder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FolderRepository
{
    public function createRootFolder(int $user_id) : Builder|Model
    {
        return Folder::query()
            ->firstOrCreate([
                'title' => null,
                'user_id' => $user_id,
            ]);
    }

    public function createUserFolder(string $folderTitile, int $user_id) : Builder|Model
    {
        return Folder::query()
            ->firstOrCreate([
                'title' => $folderTitile,
                'user_id' => $user_id,
            ]);
    }

    public function findFolderByTitle(string $folderTitle, int $user_id) : Builder|Model
    {
        return Folder::query()->firstOrCreate(['title' => $folderTitle, 'user_id' => $user_id]);
    }
}
