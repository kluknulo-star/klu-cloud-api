<?php

namespace App\Common\DTOs;

class PagingDTO
{
    public const PER_PAGE = 20;

    public function __construct(public int $page = 1, public int $perPage = self::PER_PAGE)
    {
    }
}
