<?php

namespace App\Folders\Controllers;

use App\Folders\Requests\CreateFolderRequest;
use App\Folders\Services\FolderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class FolderController extends BaseController
{

    public function __construct(private FolderService $userService)
    {
    }

    public function store(CreateFolderRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $newFolder = $this->userService->createUserFolder($validated['folder_name'], $validated['user_id']);
        return response()->json(['result' => "created new user ($newFolder->title)"]);
    }

}
