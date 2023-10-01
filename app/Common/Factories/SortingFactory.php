<?php

namespace App\Common\Factories;

use Illuminate\Http\Request;
use App\Common\DTOs\SortingDTO;

class SortingFactory
{
    public static function fromRequest(Request $request): SortingDTO
    {
        $dto = new SortingDTO();
        $dto->sortBy = $request->get('sort_by', 'id');
        $dto->sortDir = $request->get('sort_dir', SortingDTO::DIR_ASC);

        return $dto;
    }
}
