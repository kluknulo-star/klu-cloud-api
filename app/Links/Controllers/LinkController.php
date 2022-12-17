<?php

namespace App\Links\Controllers;


use App\Files\Repository\FileRepository;
use App\Files\Services\FileService;
use App\Folders\Repository\FolderRepository;
use App\Links\Models\Link;
use App\Links\Repository\LinkRepository;
use App\Links\Requests\LinkRequest;
use App\Users\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
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
            return response()->json(['error' => 'Не существует файла ' . $request['file_title']]);
        }

        $link = $this->linkRepository->createLink($file->file_uuid);
        $url = route('link.shared', ['link_uuid' => $link->link_uuid]);

        return response()->json([
            'result' => 'Публичная ссылка на файл ' . $file->title,
            'url' => $url
        ]);

    }

    public function download(Request $request, string $link_uuid)
    {
        $link = $this->linkRepository->findLink($link_uuid);
        $file = $link->file;

        if (!Storage::exists($file->path)){
            $file->delete();
            $link->delete();
            return response()->json(['error' => 'Произошла ошибка. Файла ' . $request['file_title'] .' не существует']);
        }
        return Storage::download($file->path);
    }

    public function destroy(LinkRequest $request)
    {
        $file = $this->fileRepository->findFile($request['user_id'], $request['file_title']);
        $link = $file->link;

        if (!$link)
        {
            return response()->json(['error' => 'Файл ' . $request['file_title'] .' является приватным']);
        }

        $link->delete();

        return response()->json([ 'result' => 'Публичная ссылка была удалена для файла ' . $file->title ]);
    }


}
