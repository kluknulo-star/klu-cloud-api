<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Folders\Models\Folder;
use App\Folders\Repository\FolderRepository;
use App\Folders\Services\FolderService;
use App\Users\Models\User;
use App\Users\Repository\UserRepository;
use App\Users\Services\UserService;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function __construct(
        private UserRepository $userRepository,
        private FolderRepository $folderRepository,
        private UserService $userService,
        private FolderService $folderService)
    {
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */


    public function run()
    {
//        $userRepository = new UserRepository();
//        $folderRepository = new FolderRepository();
//        $userService = new UserService();
//        $folderService = new FolderService();
        $validated = [
                'name' => 'kirill',
                'email' => 'kluknulo@mail.ru',
                'password' => 'Kirillkirill1!',
            ];

        $newUser = $this->userRepository->store($validated);
        /** @var Folder $folder */

        if (!$this->folderService->createRootFolder($newUser->user_id))
        {
            optional($newUser)->delete();
        }

        $folder = $this->folderRepository->createRootFolder($newUser->user_id);
        $this->userService->addRootFolder($newUser, $folder->folder_uuid);
    }
}
