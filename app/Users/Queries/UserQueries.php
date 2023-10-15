<?php

namespace App\Users\Queries;

use App\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserQueries
{
    public function findUser(int $userId): User
    {
        return User::findOrFail($userId);
    }

//    public function store(array $validated)
//    {
//        $validated['password'] = Hash::make($validated['password']);
//        $validated['token'] = Hash::make(rand(0, 999999));
//        $validated['free_space'] = 104857600;
//        return User::create($validated);
//    }

    public function findUserByEmail(string $email): User
    {
        return User::query()
            ->where('email', $email)
            ->firstOrFail();
    }
}