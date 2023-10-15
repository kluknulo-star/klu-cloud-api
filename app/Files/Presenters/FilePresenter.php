<?php

namespace App\Files\Presenters;

use App\Files\Models\File;
use App\Files\ResourceModels\FileResource;

final class FilePresenter
{
    public function present(File $file): FileResource
    {
        $resource = new FileResource();

        $resource->name = $file->name;
        $resource->size = $file->size;

        return $resource;
    }
}