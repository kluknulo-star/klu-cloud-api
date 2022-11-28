<?php

namespace App\Folders\Models;

use App\Files\Models\File;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property string $folder_uuid
 * @property string $title
 * @property string $path
 * @property int $size
 */

class Folder extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'folder_uuid';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'folder_uuid', 'folder_uuid');
    }

}
