<?php

namespace App\Folders\Models;


/**
 * @property int $user_id
 * @property string $token
 * @property string $email
 * @property string $name
 */

class Folder extends Authenticatable
{

    protected $primaryKey = 'folder_uid';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
