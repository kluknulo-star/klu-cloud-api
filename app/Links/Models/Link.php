<?php

namespace App\Links\Models;

use App\Files\Models\File;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $link_uuid
 * @property string $title
 * @property string $path
 * @property int $size
 */

class Link extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function file()
    {
        return $this->belongsTo(File::class, 'file_uuid');
    }

}
