<?php

namespace App\Files\Services;

use App\Files\Repository\FileRepository;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function __construct(protected FileRepository $fileRepository)
    {
    }

    public function saveUserFile(string $userId,mixed $file,string $uuidFolder)
    {
        $title = $file->getClientOriginalName();
        $size = $file->getSize();
        $path = Storage::put("disk/$userId", $file);

        $this->fileRepository->saveUserFile($uuidFolder, $title, $path, $size);

        return true;
    }



}
