<?php

namespace App\Users\Repository;

use App\Users\Models\Folder;

class UserRepository
{
    public function findUser(int $user_id)
    {
        return Folder::query()->findOrFail($user_id);
    }

    public function store(array $validated)
    {
        return Folder::create($validated);
    }

    public function findUserByEmail(string $email) : \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        return Folder::query()->where('email','=', $email)
                ->first();
    }
}
