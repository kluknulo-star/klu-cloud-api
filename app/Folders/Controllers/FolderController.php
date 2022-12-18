<?php

namespace App\Folders\Controllers;

use App\Folders\Repository\FolderRepository;
use App\Folders\Requests\CreateFolderRequest;
use App\Folders\Services\FolderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class FolderController extends BaseController
{

    public function __construct(
        private FolderService $folderService,
        private FolderRepository $folderRepository
    )
    {
    }

    public function store(CreateFolderRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (!$this->folderService->createUserFolder($validated['folder_name'], $validated['user_id'])){
            return response()->json(['error' => "Error when creating the user's root folder"]);
        }
        $newFolder = $this->folderRepository->createUserFolder($validated['folder_name'], $validated['user_id']);

        return response()->json(['result' => "created new folder ($newFolder->title)"]);
    }

}
