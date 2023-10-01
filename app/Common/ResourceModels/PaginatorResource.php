<?php

namespace App\Common\ResourceModels;

class PaginatorResource extends AbstractResourceModel
{
    public int $total;

    public int $perPage;

    public int $currentPage;

    public ?int $from = null;

    public ?int $to = null;

    public int $lastPage;

    /** @var array<AbstractResourceModel> */
    public array $items = [];
}
