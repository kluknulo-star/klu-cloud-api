<?php

namespace App\Links\Repository;


use App\Links\Models\Link;
use App\Folders\Models\Folder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LinkRepository
{
    public function createLink(string $fileUuid) : Builder|Model
    {
        return Link::query()
            ->firstOrCreate(
            [
                'file_uuid' => $fileUuid
            ]);
    }

    public function findLink(string $linkUuid)
    {
        return Link::query()
            ->where(
                [
                    'link_uuid' => $linkUuid
                ])->first();
    }
}


