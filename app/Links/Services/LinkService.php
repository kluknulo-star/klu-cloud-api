<?php

namespace App\Links\Services;

use App\Links\Repository\LinkRepository;
use Illuminate\Support\Facades\Storage;

class LinkService
{

    public function saveUserLink(int $userId,mixed $file,string $uuidFolder) : bool|string
    {
//        return Storage::append("disk/$userId", $file);
        return Storage::put("disk/$userId", $file);
    }

    public function deleteUserLink(string $path) : void
    {
        $path = Storage::delete($path);
    }

    public function isLinksPhpMimes(string $fileMime) : bool
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
