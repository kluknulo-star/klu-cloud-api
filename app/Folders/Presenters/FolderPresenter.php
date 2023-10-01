<?php

namespace App\Folders\Presenters;

use App\Folders\Models\Folder;
use App\Folders\ResourceModels\FolderResource;

class FolderPresenter
{
    public function present(Folder $folder): FolderResource
    {
        $resource = new FolderResource();
        $resource->name = $folder->name;
        $resource->files = $folder->files ? $folder->files : [];

        return $resource;
    }
}