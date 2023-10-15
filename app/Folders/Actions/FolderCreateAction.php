<?php

namespace App\Folders\Actions;

use App\Folders\DTOs\FolderCreateDTO;
use App\Folders\Models\Folder;

class FolderCreateAction
{
    public function execute(FolderCreateDTO $folderDTO): Folder
    {
        $folder = new Folder();

        $folder->name = $folderDTO->name;
        $folder->user_id = $folderDTO->userId;

        $folder->save();
        $folder->refresh();

        return $folder;
    }
}