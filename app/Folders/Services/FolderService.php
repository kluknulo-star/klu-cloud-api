<?php

namespace App\Folders\Services;
use App\Folders\Models\Folder;
use App\Folders\Repository\FolderRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class FolderService
{
    public function __construct(protected FolderRepository $userRepository)
    {
    }

    public function createRootFolder(int $user_id)
    {
        Storage::makeDirectory("disk/$user_id");
        return $this->userRepository->createRootFolder($user_id);
    }

    public function createUserFolder(string $folderTitle, int $user_id)
    {
        Storage::makeDirectory("disk/$user_id/$folderTitle");
        return $this->userRepository->createUserFolder($folderTitle, $user_id);
    }

    public function findUuidFolder(string $folderTitle, int $user_id) : string|null
    {

        $folder = $this->userRepository->findFolderByTitle($folderTitle, $user_id);
        return $folder->folder_uuid;
    }

}
