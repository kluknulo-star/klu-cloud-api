<?php

namespace App\Links\Controllers;


use App\Files\Repository\FileRepository;
use App\Links\Repository\LinkRepository;
use App\Links\Requests\LinkRequest;
use App\Users\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;


class LinkController extends BaseController
{
    public function __construct(
        private FileRepository $fileRepository,
        private LinkRepository $linkRepository,
        private UserRepository $userRepository
    )
    {
    }

    /**
     * Generate or view existing link to public download
     * @param LinkRequest $request
     * @return JsonResponse
     */
    public function store(LinkRequest $request): JsonResponse
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

    /**
     * Download by public link
     * @param Request $request
     * @param string $link_uuid
     * @return JsonResponse|StreamedResponse
     */
    public function download(Request $request, string $link_uuid): StreamedResponse|JsonResponse
    {
        $link = $this->linkRepository->findLink($link_uuid);
        $file = optional($link)->file;

        if(!$file)
        {
            return response()->json(['error' => 'File does not exist ' . $request['file_title']]);
        }

        if (!Storage::exists($file->path)){
            $user = $this->userRepository->findUser($file->user_id);
            $user->free_space += optional($file)->size;
            $user->save();
            optional($file)->delete();
            optional($link)->delete();
            return response()->json(['error' => 'File does not exist ' . $request['file_title']]);
        }
        return Storage::download($file->path);
    }

    /**
     * Delete public link
     * @param LinkRequest $request
     * @return JsonResponse
     */
    public function destroy(LinkRequest $request): JsonResponse
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
