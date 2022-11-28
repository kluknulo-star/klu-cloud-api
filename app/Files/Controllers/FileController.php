<?php

namespace App\Files\Controllers;

use App\Files\Repository\FileRepository;
use App\Files\Requests\CreateFileRequest;
use App\Files\Requests\DeleteFileRequest;
use App\Files\Requests\RenameFileRequest;
use App\Files\Resources\FileResource;
use App\Files\Services\FileService;

use App\Folders\Models\Folder;
use App\Folders\Resources\FolderResource;
use App\Folders\Services\FolderService;
use App\Users\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;



class FileController extends BaseController
{
    public function __construct(
        private FileService $fileService,
        private UserService $userService,
        private FolderService $folderService,
        private FileRepository $fileRepository
    )
    {

    }

    public function index(Request $request) : JsonResponse
    {
        $user = $this->userService->findUser($request["user_id"]);
        $folders = $user->folders()->orderByDesc('created_at')->paginate(100);

        $disk['free_space'] = $user->free_space;
        foreach ($folders as $folder)
        {
            $files = $folder->files()->paginate(100);

            $filesJson = FileResource::collection($files);

            $disk['disk'][$folder->title ?? '__ROOT_FOLDER__'] = $filesJson;
        }

        return response()->json($disk);
    }


    public function store(CreateFileRequest $request): JsonResponse
    {
        $file = $request->file('file');
        $user = $this->userService->findUser($request['user_id']);

        if ($file->getSize() > $user->free_space)
        {
            return response()->json(['error' => 'Не хватает свободного пространства']);
        }

        $user->free_space -= $file->getSize();
        $user->save();

        if ($request['folder_title'])
        {
            $uuidFolder = $this->folderService->findUuidFolder($request['folder_title'], $request['user_id']);
        }
        else
        {
            $uuidFolder = $user->root_folder;
        }

        $this->fileService->saveUserFile($request['user_id'], $file, $uuidFolder);

        return response()->json(['result' => "Сохранен файл ". $file->getClientOriginalName()]);
    }

    public function show(Request $request): JsonResponse
    {
        return response()->json();
    }

    public function update(RenameFileRequest $request): JsonResponse
    {
        $oldTitle = $request['file_title'];
        $newTitle = $request['new_file_title'];

        $file = $this->fileRepository->findFile($request['user_id'], $request['file_title']);

        if (!$file)
        {
            return response()->json(['error' => "Не существует файла $oldTitle"]);
        }
        $file->title = $newTitle;
        $file->save();

        return response()->json(['result' => "Изменено название с $oldTitle на $newTitle"]);
    }

    public function destroy(DeleteFileRequest $request) : JsonResponse
    {
        $file = $this->fileRepository->findFile($request['user_id'], $request['file_title']);
        if (!$file)
        {
            return response()->json(['error' => "Не существует файла ". $request['file_title']]);
        }

        $user = $this->userService->findUser($request['user_id']);

        $user->free_space += $file->size;
        $user->save();

        $this->fileService->deleteUserFile($file->path);
        $file->delete();

        return response()->json(['result' => "Удален файл ". $request['file_title']]);
    }
}
