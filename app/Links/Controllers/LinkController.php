<?php

namespace App\Links\Controllers;


use App\Files\Repository\FileRepository;
use App\Links\Repository\LinkRepository;
use App\Links\Requests\LinkRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;


class LinkController extends BaseController
{
    public function __construct(
        private FileRepository $fileRepository,
        private LinkRepository $linkRepository
    )
    {
    }

    public function store(LinkRequest $request)
    {
        $file = $this->fileRepository->findFile($request['user_id'], $request['file_title']);

        if (!$file)
        {
            return response()->json(['error' => 'File does not exist ' . $request['file_title']]);
        }

        $link = $this->linkRepository->createLink($file->file_uuid);
        $url = route('link.shared', ['link_uuid' => $link->link_uuid]);

        return response()->json([
            'result' => 'Public link to the file ' . $file->title,
            'url' => $url
        ]);

    }

    public function download(Request $request, string $link_uuid)
    {
        $link = $this->linkRepository->findLink($link_uuid);
        $file = optional($link)->file;

        if (!$file || !Storage::exists($file->path)){
            optional($file)->delete();
            optional($link)->delete();
            return response()->json(['error' => 'File does not exist ' . $request['file_title']]);
        }
        return Storage::download($file->path);
    }

    public function destroy(LinkRequest $request)
    {
        $file = $this->fileRepository->findFile($request['user_id'], $request['file_title']);
        $link = $file->link;

        if (!$link)
        {
            return response()->json(['error' => 'File is already private (' . $request['file_title'] .')']);
        }

        $link->delete();

        return response()->json([ 'result' => 'Public link removed for file ' . $file->title ]);
    }


}
