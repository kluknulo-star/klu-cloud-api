<?php

namespace App\Common\Presenters;

use App\Common\DTOs\PagingDTO;
use App\Common\ResourceModels\PaginatorResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginatorPresenter
{
    public function present(LengthAwarePaginator $result, PagingDTO $paging): PaginatorResource
    {
        $paginator = new PaginatorResource();

        $paginator->perPage = $paging->perPage;
        $paginator->currentPage = $paging->page;
        $paginator->lastPage = $result->lastPage();
        $paginator->total = $result->total();
        $paginator->from = $result->firstItem();
        $paginator->to = $result->lastItem();

        return $paginator;
    }
}
