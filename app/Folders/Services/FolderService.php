<?php

namespace App\Folders\Services;
use App\Folders\Models\Folder;
use App\Folders\Repository\FolderRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class FolderService
{

    public function createRootFolder(int $user_id)
    {
        return Storage::makeDirectory("disk/$user_id");
    }

    public function createUserFolder(string $folderTitle, int $user_id)
    {
        return Storage::makeDirectory("disk/$user_id/$folderTitle");
    }

}
