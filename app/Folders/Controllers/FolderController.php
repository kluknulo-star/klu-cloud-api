<?php

namespace App\Folders\Controllers;

use App\Users\Requests\LoginUserRequest;
use App\Users\Requests\RegisterUserRequest;

use App\Users\Resources\UserResource;
use App\Users\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class FolderController extends BaseController
{

    public function __construct(
        private UserService $userService,
    )
    {

    }

    public function store(Request $request): JsonResponse
    {

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
