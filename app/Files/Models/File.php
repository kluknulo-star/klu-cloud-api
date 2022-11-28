<?php

namespace App\Files\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $file_uuid
 * @property string $title
 * @property string $path
 * @property int $size
 */

class File extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'file_uuid';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];


}
