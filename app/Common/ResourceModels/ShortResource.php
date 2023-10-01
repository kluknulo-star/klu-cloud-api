<?php

namespace App\Common\ResourceModels;

class ShortResource extends AbstractResourceModel
{
    public function __construct(public int $id, public string $name)
    {
    }
}
