<?php

namespace App\Users\Repository;

use App\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function findUser(int $user_id) : Builder|array|Collection|Model
    {
        return User::query()->findOrFail($user_id);
    }

    public function store(array $validated)
    {
        $validated['password'] = Hash::make($validated['password']);
        $validated['token'] = Hash::make(rand(0, 999999));
        $validated['free_space'] = 104857600;
        return User::create($validated);
    }

    public function findUserByEmail(string $email) : Builder|Model
    {
        return User::query()->where('email','=', $email)
                ->first();
    }
}
