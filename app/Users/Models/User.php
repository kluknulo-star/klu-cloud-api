<?php

namespace App\Users\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Files\Models\File;
use App\Folders\Models\Folder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $user_id
 * @property string $token
 * @property string $email
 * @property string $name
 * @property string $root_folder
 * @property int $free_space
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
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

    public function folders()
    {
        return $this->hasMany(Folder::class, 'user_id', 'user_id');
    }
}
