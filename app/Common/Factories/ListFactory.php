<?php

namespace App\Common\Factories;

use Illuminate\Http\Request;
use App\Common\DTOs\PagingDTO;

class ListFactory
{
    public static function fromRequest(Request $request): PagingDTO
    {
        $dto = new PagingDTO();
        $dto->page = (int) $request->get('page', 1);
        $dto->perPage = (int) $request->get('per_page', PagingDTO::PER_PAGE);

        return $dto;
    }
}
