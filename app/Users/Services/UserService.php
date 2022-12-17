<?php

namespace App\Users\Services;
use App\Users\Models\User;
use App\Users\Repository\UserRepository;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function addRootFolder(User $newUser, string $folder_uuid) : bool
    {
        return $newUser->update(['root_folder' => $folder_uuid]);
    }
}
