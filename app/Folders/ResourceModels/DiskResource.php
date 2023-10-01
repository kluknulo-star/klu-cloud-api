<?php

namespace App\Folders\ResourceModels;

use App\Common\ResourceModels\AbstractResourceModel;

class DiskResource extends AbstractResourceModel
{
    public int $freeSpace;

    public ?array $folders;
}