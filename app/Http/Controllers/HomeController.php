<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $statement = [];
        $statement['register'] = [
            "name" => "kirill",
            "email" => "kluknulo1@mail.ru",
            "password" => "Kirillkirill1!",
            "password_confirmation" => "Kirillkirill1!"
        ];
        $statement['register_response'] = [
            "result" => "Created new user (kirill)",
            "token" => '$2y$10$SIvdr8kTLPr3gu1iwJlhJ.ZF19G4NiLfNfs6ElY8suDaZuBFpjw8a'
        ];

        $statement['login'] = [
            "email" => "kluknulo1@mail.ru",
            "password" => "Kirillkirill1!"
        ];
        $statement['login_response'] = [
            "name" => "kirill",
            "email" => "kluknulo1@mail.ru",
            "token" => '$2y$10$SIvdr8kTLPr3gu1iwJlhJ.ZF19G4NiLfNfs6ElY8suDaZuBFpjw8a'
        ];

        $statement['token'] = '$2y$10$/zsSVB3xOTd5Ru7n';

        $statement['profile_response'] = [
            "name" => "kirill",
            "email" => "kluknulo1@mail.ru",
            "freeSpace" => 104857600,
        ];

        $statement['folders'] = [
            "folder_name" => "myNewFolder"
        ];

        $statement['folders_response'] = [
            "result" => "created new folder (myNewFolder)"
        ];


        $statement['upload_file_in_root'] = [
            "folder_name" => "myNewFolder"
        ];

        $statement['upload_file_in_root_response'] = [
            "result" => "created new folder (myNewFolder)"
        ];

        $statement['root_file'] = [
            'file' => 'file.txt',
        ];

        $statement['folder_file'] = [
            'file' => 'file.txt',
            'folder_name' => 'myNewFolder',
        ];

        $statement['update_file'] = [
            "file_title" => "receipt.pdf",
            "new_file_title" => "EditedExample.pdf"
        ];

        $statement['delete_file'] = [
            "file_title" => "receipt.pdf",
        ];

        $statement['disk_tree'] = [
            "free_space" => 103521446,
            "disk" => [
                "createFolderWithRequest" => [
                    [
                        "file_title" => "ENSA_M_4_ACL (1).pdf",
                        "size" => 893446
                    ]
                ],
                "myNewFolder" => [],
                "__ROOT_FOLDER__" => [
                    [
                        "file_title" => "baikal.png",
                        "size" => 442708
                    ]
                ]
            ]
        ];
        $statement['download_file'] = [
            "file_title" => "baikal.png",
        ];

        $statement['shared_file'] = [
            "result" => "Public link to the file baikal.png",
            "url" => "http://localhost/api/shared/9966c297-6439-4f21-a461-eed7741f8282"
        ];

        $statement['response_login'] = [
            "name" => "kirill",
            "email" => "kluknulo1@mail.ru",
            "token" => '$2y$10$s/642dJ40fxDmoXsfpUH3eQ6tLgDADer2QBW7dhY3roS02c3zYCUK'
        ];


        return view('home', compact('statement'));
    }

}
