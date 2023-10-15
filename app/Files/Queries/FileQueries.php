<?php

namespace App\Files\Queries;

use App\Files\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FileQueries
{
//    public function saveUserFile(string $uuidFolder, string $title, string $path, int $size, int $userId): Builder|Model
//    {
//        return File::query()
//            ->firstOrCreate([
//                'folder_uuid' => $uuidFolder,
//                'title' => $title,
//                'path' => $path,
//                'size' => $size,
//                'user_id' => $userId
//            ]);
//    }

    public function findFileByUserAndName(int $userId, string $name): ?File
    {
        return File::query()
            ->where([
                'user_id' => $userId,
                'name' => $name,
            ])
            ->first();
    }
}