<?php

namespace App\Files\Repository;


use App\Files\Models\File;
use App\Folders\Models\Folder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FileRepository
{
    public function saveUserFile(string $uuidFolder, string $title, string $path, int $size, int $userId): Builder|Model
    {
        return File::query()
            ->firstOrCreate([
                'folder_uuid' => $uuidFolder,
                'title' => $title,
                'path' => $path,
                'size' => $size,
                'user_id' => $userId
            ]);
    }

    public function findFile(int $user_id, string $title): Builder|Model|null
    {
        return File::query()
            ->where([
                'user_id' => $user_id,
                'title' => $title,
            ])->first();
    }


}


