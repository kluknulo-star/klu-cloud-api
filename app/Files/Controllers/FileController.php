<?php

namespace App\Files\Controllers;

use App\Files\Requests\CreateFileRequest;
use App\Files\Resources\FileResource;
use App\Files\Services\FileService;

use App\Folders\Models\Folder;
use App\Folders\Resources\FolderResource;
use App\Folders\Services\FolderService;
use App\Users\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use function PHPUnit\Framework\isEmpty;


class FileController extends BaseController
{
    public function __construct(
        private FileService $fileService,
        private UserService $userService,
        private FolderService $folderService,
    )
    {

    }

    public function index(Request $request) : JsonResponse
    {
        $user = $this->userService->findUser($request["user_id"]);
        $folders = $user->folders()->orderByDesc('created_at')->paginate(100);

        $disk = [];
        foreach ($folders as $folder)
        {

            $files = $folder->files()->paginate(100);

            $folderJson = new FolderResource($folder);
            $filesJson = FileResource::collection($files);

            $folderWithFiles = sizeof($filesJson) ? [$folderJson, $filesJson] : $folderJson;

            $disk[] = $folderWithFiles;
        }

        return response()->json($disk);
    }


    public function store(CreateFileRequest $request): JsonResponse
    {
        $file = $request->file('file');

        if ($request['folder_title'])
        {
            $uuidFolder = $this->folderService->findUuidFolder($request['folder_title'], $request['user_id']);
        }
        else
        {
            $user = $this->userService->findUser($request['user_id']);
            $uuidFolder = $user->root_folder;
        }

        $saved = $this->fileService->saveUserFile($request['user_id'], $file, $uuidFolder);

        return response()->json($saved);
    }

    public function show(Request $request): JsonResponse
    {
        return response()->json();
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
