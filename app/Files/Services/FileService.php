<?php

namespace App\Files\Services;

use App\Files\Repository\FileRepository;
use Illuminate\Support\Facades\Storage;

class FileService
{

    public function saveUserFile(int $userId,mixed $file,string $uuidFolder) : bool|string
    {
//        return Storage::append("disk/$userId", $file);
        return Storage::put("disk/$userId", $file);
    }

    public function deleteUserFile(string $path) : void
    {
        $path = Storage::delete($path);
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
