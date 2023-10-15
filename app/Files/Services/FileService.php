<?php

namespace App\Files\Services;

use App\Files\Repository\FileRepository;
use Illuminate\Support\Facades\Storage;

class FileService
{

    public function deleteUserFile(string $path): bool
    {
        return Storage::delete($path);
    }

    public function isFilesPhpMimes(string $fileMime) : bool
    {
        $mimesPhp = [
            'application/x-httpd-php',
            'application/php',
            'application/x-php',
            'text/php',
            'text/x-php',
            'application/x-httpd-php-source'
        ];

        return in_array($fileMime, $mimesPhp);
    }
}
