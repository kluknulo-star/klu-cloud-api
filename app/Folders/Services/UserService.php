<?php

namespace App\Folders\Services;
use App\Folders\Models\Folder;
use App\Folders\Repository\FolderRepository;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected FolderRepository $userRepository)
    {
    }

    public function findUser(int $user_id)
    {
        return $this->userRepository->findUser($user_id);
    }

    public function findUserByEmail(array $validated) : Builder|\Illuminate\Database\Eloquent\Model
    {
        return $this->userRepository->findUserByEmail($validated['email']);
    }

    public function store(array $validated): Folder
    {
        $validated['password'] = Hash::make($validated['password']);
        $validated['token'] = Hash::make(rand(0, 999999));
        $validated['free_space'] = 104857600;
        return $this->userRepository->store($validated);
    }
}
