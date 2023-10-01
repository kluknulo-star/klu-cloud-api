<?php

namespace App\Folders\ResourceModels;

use App\Common\ResourceModels\AbstractResourceModel;

class FolderResource extends AbstractResourceModel
{
    public string $name;

    public ?array $files;
}