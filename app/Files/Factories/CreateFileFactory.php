<?php

namespace App\Files\Factories;

use App\Files\DTOs\CreateFileDTO;

class CreateFileFactory
{
    public static function fromRequest($request): CreateFileDTO
    {
        $dto = new CreateFileDTO();

        $dto->file = $request->file('file');
        $dto->userId = $request->get('user_id');
        $dto->folderName = $request->get('folder_name');

        return $dto;
    }
}