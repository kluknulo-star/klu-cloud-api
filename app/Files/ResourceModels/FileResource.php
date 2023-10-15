<?php

namespace App\Files\ResourceModels;

use App\Common\ResourceModels\AbstractResourceModel;

class FileResource extends AbstractResourceModel
{
    public string $name;

    public int $size;
}