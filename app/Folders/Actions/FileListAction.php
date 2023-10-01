<?php

namespace App\Folders\Actions;

use App\Common\DTOs\PagingDTO;
use App\Common\Presenters\PaginatorPresenter;
use App\Common\ResourceModels\PaginatorResource;
use App\Files\Resources\FileResource;
use App\Folders\Presenters\DiskPresenter;
use App\Folders\Queries\FolderQueries;
use App\Users\Models\User;

class FileListAction
{
    public function __construct(
        private readonly FolderQueries $folderQueries,
        private readonly PaginatorPresenter $paginatorPresenter,
        private readonly DiskPresenter $diskPresenter,
    ) {
    }

    public function execute(PagingDTO $paging, User $user): PaginatorResource
    {
        $folders = $this->folderQueries->getFoldersByUserId($user->id, $paging);
        $paginator = $this->paginatorPresenter->present($folders, $paging);

        $disk['free_space'] = $user->free_space;
        foreach ($folders->items() as $folder)
        {
            $files = $folder->files;
            $filesJson = FileResource::collection($files);
            $disk['disk'][$folder->title ?? '__ROOT_FOLDER__'] = $filesJson;
        }

        $paginator->items[] = $this->diskPresenter->present($folders->items(), $user);

        return $paginator;
    }
}