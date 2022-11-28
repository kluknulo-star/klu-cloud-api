<?php

namespace App\Files\Repository;


use App\Files\Models\File;
use App\Folders\Models\Folder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FileRepository
{
    public function saveUserFile(string $uuidFolder, string $title, string $path, int $size): Builder|Model
    {
        return File::query()
            ->firstOrCreate([
                'folder_uuid' => $uuidFolder,
                'title' => $title,
                'path' => $path,
                'size' => $size
            ]);
    }

}
