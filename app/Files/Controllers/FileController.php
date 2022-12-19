<?php

namespace App\Files\Controllers;

use App\Files\Repository\FileRepository;
use App\Files\Requests\CreateFileRequest;
use App\Files\Requests\TitleFileRequest;
use App\Files\Requests\TitleFolderFileRequest;
use App\Files\Requests\RenameFileRequest;
use App\Files\Resources\FileResource;
use App\Files\Services\FileService;
use App\Folders\Repository\FolderRepository;
use App\Users\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;


class FileController extends BaseController
{
    public function __construct(
        private FileService $fileService,
        private FileRepository $fileRepository,
        private UserRepository $userRepository,
        private FolderRepository $folderRepository,
    )
    {

    }

    /**
     * Show all files and folders in user disk
     * @param Request $request
     * @return JsonResponse
     */
    public function disk(Request $request) : JsonResponse
    {
        $user = $this->userRepository->findUser($request["user_id"]);
        $folders = $user->folders()->orderByDesc('created_at')->paginate(1000);

        $diskSpace = 0;
        foreach ($folders as $folder)
        {
            $files = $folder->files()->paginate(100);
            $filesJson = FileResource::collection($files);
            $disk['disk'][$folder->title ?? '__ROOT_FOLDER__'] = $filesJson;
        }
        return response()->json($disk);
    }

    /**
     * Create file on user drive
     * @param CreateFileRequest $request
     * @return JsonResponse
     */
    public function store(CreateFileRequest $request): JsonResponse
    {
        $file = $request->file('file');
        $user = $this->userRepository->findUser($request['user_id']);
        $isExistFile = $this->fileRepository->findFile($request['user_id'], $file->getClientOriginalName());

        if ($isExistFile){
            return response()->json(['error' => 'File with that title already exists']);
        }

        if ($this->fileService->isFilesPhpMimes($file->getMimeType()))
        {
            return response()->json(['error' => 'Php files are not supported']);
        }

        if ($file->getSize() > $user->free_space)
        {
            return response()->json(['error' => 'Not enough free disk space']);
        }
        $user->free_space -= $file->getSize();
        $user->save();

        $uuidFolder = $user->root_folder;
        if ($request['folder_title'])
        {
            $folder = $this->folderRepository->findFolderByTitle($request['folder_title'], $request['user_id']);
            $uuidFolder = $folder->folder_uuid;
        }

        $path = $this->fileService->saveUserFile($request['user_id'], $file, $uuidFolder);

        if (!$path){
            return response()->json(['error' => 'Error when uploading a file to the server']);
        }

        $title = $file->getClientOriginalName();
        $size = $file->getSize();
        $this->fileRepository->saveUserFile($uuidFolder, $title, $path, $size, $request['user_id']);

        return response()->json(['result' => 'File saved (' . $file->getClientOriginalName().')' ]);
    }


    /**
     * Rename file on user drive
     * @param RenameFileRequest $request
     * @return JsonResponse
     */
    public function update(RenameFileRequest $request): JsonResponse
    {
        $oldTitle = $request['file_title'];
        $newTitle = $request['new_file_title'];

        $file = $this->fileRepository->findFile($request['user_id'], $oldTitle);
        $isTitleExist = $this->fileRepository->findFile($request['user_id'], $newTitle);

        if($isTitleExist)
        {
            return response()->json(['error' => "The file already exists ($newTitle)"]);
        }

        if (!$file)
        {
            return response()->json(['error' => "File does not exist ($oldTitle)"]);
        }
        $file->title = $newTitle;
        $file->save();

        return response()->json(['result' => "Title was changed from $oldTitle on $newTitle"]);
    }

    /**
     * Delete file on user drive
     * @param TitleFolderFileRequest $request
     * @return JsonResponse
     */
    public function destroy(TitleFolderFileRequest $request) : JsonResponse
    {
        $file = $this->fileRepository->findFile($request['user_id'], $request['file_title']);
        if (!$file)
        {
            return response()->json(['error' => 'File does not exist (' . $request['file_title'] .')']);
        }

        $user = $this->userRepository->findUser($request['user_id']);

        $user->free_space += $file->size;
        $user->save();

        $this->fileService->deleteUserFile($file->path);
        $file->delete();

        return response()->json(['result' => 'File deleted ('. $request['file_title'].')']);
    }

    /**
     * Download file from user disk
     * @param TitleFolderFileRequest $request
     * @return JsonResponse|StreamedResponse
     */
    public function download(TitleFolderFileRequest $request)
    {
        $file = $this->fileRepository->findFile($request['user_id'], $request['file_title']);


        if (!isset($file))
        {
            return response()->json(['error' => 'File does not exist (' . $request['file_title'] . ')']);
        }

        if (!Storage::exists($file->path)){
            $user = $this->userRepository->findUser($request['user_id']);
            $user->free_space += optional($file)->size;
            $user->save();

            $link = $file->link;
            optional($link)->delete();
            optional($file)->delete();
            return response()->json(['error' => 'File does not exist (' . $request['file_title'] . ')']);
        }
        return Storage::download($file->path);
    }

}
