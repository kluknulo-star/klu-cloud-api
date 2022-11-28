<?php

namespace App\Users\Repository;

use App\Users\Models\User;

class UserRepository
{
    public function findUser(int $user_id)
    {
        return User::query()->findOrFail($user_id);
    }

    public function store(array $validated)
    {
        return User::create($validated);
    }

    public function findUserByEmail(string $email) : \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        return User::query()->where('email','=', $email)
                ->first();
    }
}
