<?php

namespace App\Files\Repository;


use App\Files\Models\File;
use App\Folders\Models\Folder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FileRepository
{
    /**
     * Save user file in DB
     * @param string $uuidFolder
     * @param string $title
     * @param string $path
     * @param int $size
     * @param int $userId
     * @return Builder|Model
     */
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

    /**
     * Find user file by user_id
     * @param int $user_id
     * @param string $title
     * @return Builder|Model|null
     */
    public function findFile(int $user_id, string $title): Builder|Model|null
    {
        return File::query()
            ->where([
                'user_id' => $user_id,
                'title' => $title,
            ])->first();
    }


}


