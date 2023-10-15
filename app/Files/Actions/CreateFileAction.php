<?php

namespace App\Files\Actions;

use App\Files\DTOs\CreateFileDTO;
use App\Files\Exceptions\FailedUploadFileException;
use App\Files\Exceptions\FileAlreadyExistException;
use App\Files\Exceptions\NotEnoughDiskSpace;
use App\Files\Models\File;
use App\Files\Queries\FileQueries;
use App\Folders\Actions\FolderCreateAction;
use App\Folders\DTOs\FolderCreateDTO;
use App\Folders\Models\Folder;
use App\Folders\Queries\FolderQueries;
use App\Users\Models\User;
use App\Users\Queries\UserQueries;
use Illuminate\Support\Facades\Storage;

final readonly class CreateFileAction
{
    public function __construct(
        private FileQueries $fileQueries,
        private UserQueries $userQueries,
        private FolderQueries $folderQueries,
        private FolderCreateAction $folderCreateAction,
    ) {
    }

    public function execute(CreateFileDTO $fileDTO): File
    {
        $user = $this->userQueries->findUser($fileDTO->userId);

        $this->checkRules($fileDTO, $user);

        $folderUuid = $user->root_folder;
        if ($fileDTO->folderName)
        {
            $folder = $this->findOrCreateFolderByTitle($fileDTO);
            $folderUuid = $folder->uuid;
        }

        $path = $this->saveStorageUserFile($fileDTO);

        $file = new File();
        $file->folder_uuid = $folderUuid;
        $file->name = $fileDTO->name;
        $file->path = $path;
        $file->size = $fileDTO->file->getSize();
        $file->user_id = $fileDTO->userId;
        $file->save();

        $user->free_space -= $fileDTO->file->getSize();
        $user->save();

        return $file;
    }

    private function checkRules(CreateFileDTO $fileDTO, User $user): void
    {
        $isExistFile = $this->fileQueries->findFileByUserAndName($fileDTO->userId, $fileDTO->file->getClientOriginalName());

        if ($isExistFile){
            new FileAlreadyExistException(trans('file.already_exist'));
        }

//        if ($this->fileService->isFilesPhpMimes($file->getMimeType()))
//        {
//            return response()->json(['error' => 'Php files are not supported']);
//        }

        if ($fileDTO->file->getSize() > $user->free_space)
        {
            new NotEnoughDiskSpace(trans('file.disk.not_enough_space'));
        }
    }

    private function findOrCreateFolderByTitle(CreateFileDTO $fileDTO): Folder
    {
        $folder = $this->folderQueries->findFolderByTitle($fileDTO->folderName, $fileDTO->userId);

        if (!$folder){
            $folderDTO = new FolderCreateDTO();

            $folderDTO->name = $fileDTO->folderName;
            $folderDTO->userId = $fileDTO->userId;

            $folder = $this->folderCreateAction->execute($folderDTO);
        }

        return $folder;
    }

    private function saveStorageUserFile(CreateFileDTO $fileDTO): string
    {
        $filePath = "disk/{$fileDTO->userId}";

        if ($fileDTO->folderName){
            $filePath = "disk/{$fileDTO->userId}/{$fileDTO->folderName}";
        }

        $path = Storage::put($filePath, $fileDTO->file);

        if (!$path){
            new FailedUploadFileException(trans('file.failed_upload'));
        }

        return $path;
    }
}