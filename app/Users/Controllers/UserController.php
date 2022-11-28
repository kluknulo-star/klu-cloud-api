<?php

namespace App\Users\Controllers;



use App\Folders\Models\Folder;
use App\Folders\Services\FolderService;
use App\Users\Models\User;
use App\Users\Requests\LoginUserRequest;
use App\Users\Requests\RegisterUserRequest;

use App\Users\Resources\UserResource;
use App\Users\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{

    public function __construct(
        private UserService $userService,
        private FolderService $folderService
    )
    {

    }

    public function store(RegisterUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $newUser = $this->userService->store($validated);

        /** @var Folder $folder */
        $folder = $this->folderService->createRootFolder($newUser->user_id);
        $this->userService->addRootFolder($newUser, $folder->folder_uuid);

        return response()->json(['result' => "created new user ($newUser->name)",
            'token' => $newUser->token], 201);
    }

    public function show(Request $request): JsonResponse
    {
        $user = $this->userService->findUser($request['user_id']);
        $profile = new UserResource($user);
        return response()->json($profile);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (Auth::attempt($validated)) {
            $user = $this->userService->findUserByEmail($validated);
            /** @var User $user */
            $loginInform = [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->token
            ];
            return response()->json($loginInform);
        }
        else
        {
            return response()->json(['error' => 'The invalid input data'],401);
        }
    }
}
