<?php

namespace App\Files\Models;

use App\Links\Models\Link;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $uuid
 * @property string $folder_uuid
 * @property string $name
 * @property string $path
 * @property int $size
 * @property int $user_id
 *
 * @property User $user
 * @property Link $link
 */

class File extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function link()
    {
        return $this->hasOne(Link::class, 'file_uuid');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
