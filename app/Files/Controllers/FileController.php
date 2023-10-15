<?php

namespace App\Files\Controllers;

use App\Common\Factories\ListFactory;
use App\Common\Traits\JsonResponsible;
use App\Files\Actions\CreateFileAction;
use App\Files\Factories\CreateFileFactory;
use App\Files\Presenters\FilePresenter;
use App\Files\Repository\FileRepository;
use App\Files\Requests\CreateFileRequest;
use App\Files\Requests\RenameFileRequest;
use App\Files\Requests\TitleFolderFileRequest;
use App\Files\Services\FileService;
use App\Folders\Actions\FileListAction;
use App\Folders\Repository\FolderRepository;
use App\Users\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends BaseController
{
    use JsonResponsible;

    public function __construct(
        private readonly FileService $fileService,
        private readonly FileRepository $fileRepository,
        private readonly UserRepository $userRepository,
        private readonly FolderRepository $folderRepository,
    ) {
    }

    public function disk(Request $request, FileListAction $action) : JsonResponse
    {
        $pagingDto = ListFactory::fromRequest($request);

        return $this->success($action->execute($pagingDto, Auth::user()));
    }

    public function store(CreateFileRequest $request, CreateFileAction $action, FilePresenter $presenter): JsonResponse
    {
        $fileDTO = CreateFileFactory::fromRequest($request);
        $file = $action->execute($fileDTO);

        return $this->success($presenter->present($file));
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
