<?php

namespace App\Files\DTOs;

use Illuminate\Http\UploadedFile;

class CreateFileDTO
{
    public array | UploadedFile | null $file;

    public int $userId;

    public int $name;

    public ?string $folderName;
}