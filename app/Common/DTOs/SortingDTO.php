<?php

namespace App\Common\DTOs;

class SortingDTO
{
    public const DIR_ASC = 'asc';

    public const DIR_DESC = 'desc';

    public function __construct(public string $sortBy = 'id', public string $sortDir = self::DIR_ASC)
    {
    }
}
