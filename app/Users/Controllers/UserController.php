<?php

namespace App\Users\Controllers;


use App\Folders\Models\Folder;
use App\Folders\Repository\FolderRepository;
use App\Folders\Services\FolderService;
use App\Users\Models\User;
use App\Users\Repository\UserRepository;
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
        private FolderService $folderService,
        protected UserRepository $userRepository,
        protected FolderRepository $folderRepository
    )
    {
    }

    /**
     * Register new user
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function store(RegisterUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $newUser = $this->userRepository->store($validated);
        /** @var Folder $folder */

        if (!$this->folderService->createRootFolder($newUser->user_id))
        {
            optional($newUser)->delete();
            return response()->json(['error' => "Error when creating the user's root folder"], );
        }

        $folder = $this->folderRepository->createRootFolder($newUser->user_id);
        $this->userService->addRootFolder($newUser, $folder->folder_uuid);
        return response()->json(['result' => "Created new user ($newUser->name)",
            'token' => $newUser->token], 201);
    }

    /**
     * Get profile of user
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $user = $this->userRepository->findUser($request['user_id']);
        $profile = new UserResource($user);
        return response()->json($profile);
    }

    /**
     * Authenticate user
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (!Auth::attempt($validated)) {
            return response()->json(['error' => 'The invalid input data'],401);
        }

        $user = $this->userRepository->findUserByEmail($validated['email']);
        /** @var User $user */
        $loginInform = [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $user->token
        ];
        return response()->json($loginInform);
    }
}
