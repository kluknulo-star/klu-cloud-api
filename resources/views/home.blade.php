<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js' ])
</head>
<body>

<div class="container mt-2">
    <div class="row">
        <div class="col-12 text-center">
            <h1>API klu-cloud</h1>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none link-success" data-bs-toggle="collapse" href="#post_register" role="button"
               aria-expanded="false" aria-controls="post_register">
                <h4 class="mb-1">POST: /api/register</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Регистрация пользователя
            </p>
            <div class="collapse" id="post_register">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border p-2">
                <pre class="mt-0 mb-0">{{json_encode($statement['register'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none link-success" data-bs-toggle="collapse" href="#post_login" role="button"
               aria-expanded="false" aria-controls="post_login">
                <h4 class="mb-0">POST: /api/login</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Вход и получение токена
            </p>
            <div class="collapse mb-2" id="post_login">
                <div class="col-auto mb-2">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border p-2">
                <pre class="mt-0 mb-0">{{json_encode($statement['login'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="bg-dark text-white border-bottom rounded-top px-2 pt-1">
                                Response
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark rounded-end rounded-bottom p-2">
                        {{--                        <p class="card-subtitle text-end mb-0">Response</p>--}}
                        <pre class="mt-0 mb-0">{{json_encode($statement['response_login'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none" data-bs-toggle="collapse" href="#post_profile" role="button"
               aria-expanded="false" aria-controls="post_profile">
                <h4 class="mb-0">GET: /api/profile</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Данные профиля
            </p>
            <div class="collapse mb-2" id="post_profile">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="bg-dark text-white border-bottom rounded-top px-2 pt-1">
                                Response
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark rounded-end rounded-bottom p-2">
                        {{--                        <p class="card-subtitle text-end mb-0">Response</p>--}}
                        <pre class="mt-0 mb-0">{{json_encode($statement['profile_response'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none link-success" data-bs-toggle="collapse" href="#post_folders" role="button"
               aria-expanded="false" aria-controls="post_folders">
                <h4 class="mb-0">POST: /api/folders</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Создать папку
            </p>
            <div class="collapse" id="post_folders">

                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark  ">
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border overflow-hidden">
                        <div class="card-header bg-white border-bottom border-dark p-2">
                            <p class="mb-0 small"><b>Headers</b></p>
                            <p class="mb-0 small"><i>Authorization:</i> {{$statement['token']}}</p>
                        </div>
                        <div class="p-2 rounded-bottom">
                        <pre class="mt-0 mb-0">{{json_encode($statement['folders'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none link-success" data-bs-toggle="collapse" href="#upload_in_the_root" role="button"
               aria-expanded="false" aria-controls="upload_in_the_root">
                <h4 class="mb-0">POST: /api/files</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Загрузка в корневую папку
            </p>
            <div class="collapse mb-2" id="upload_in_the_root">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark  ">
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border overflow-hidden">
                        <div class="card-header bg-white border-bottom border-dark p-2">
                            <p class="mb-0 small"><b>Headers</b></p>
                            <p class="mb-0 small"><i>Authorization:</i> {{$statement['token']}}</p>
                        </div>
                        <div class="p-2 rounded-bottom">
                        <pre class="mt-0 mb-0">{{json_encode($statement['root_file'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none link-success" data-bs-toggle="collapse" href="#upload_in_folder" role="button"
               aria-expanded="false" aria-controls="upload_in_folder">
                <h4 class="mb-0">POST: /api/files</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Загрузка в конкреткую папку
            </p>
            <div class="collapse mb-2" id="upload_in_folder">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark  ">
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border overflow-hidden">
                        <div class="card-header bg-white border-bottom border-dark p-2">
                            <p class="mb-0 small"><b>Headers</b></p>
                            <p class="mb-0 small"><i>Authorization:</i> {{$statement['token']}}</p>
                        </div>
                        <div class="p-2 rounded-bottom">
                        <pre class="mt-0 mb-0">{{json_encode($statement['folder_file'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none link-warning" data-bs-toggle="collapse" href="#update_file" role="button"
               aria-expanded="false" aria-controls="update_file">
                <h4 class="mb-0">PUT: /api/files</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Изменение имени файла
            </p>
            <div class="collapse mb-2" id="update_file">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark  ">
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border overflow-hidden">
                        <div class="card-header bg-white border-bottom border-dark p-2">
                            <p class="mb-0 small"><b>Headers</b></p>
                            <p class="mb-0 small"><i>Authorization:</i> {{$statement['token']}}</p>
                        </div>
                        <div class="p-2 rounded-bottom">
                        <pre class="mt-0 mb-0">{{json_encode($statement['update_file'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none link-danger" data-bs-toggle="collapse" href="#delete_file" role="button"
               aria-expanded="false" aria-controls="delete_file">
                <h4 class="mb-0">DELETE: /api/files</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Удаление файла
            </p>
            <div class="collapse mb-2" id="delete_file">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark  ">
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border overflow-hidden">
                        <div class="card-header bg-white border-bottom border-dark p-2">
                            <p class="mb-0 small"><b>Headers</b></p>
                            <p class="mb-0 small"><i>Authorization:</i> {{$statement['token']}}</p>
                        </div>
                        <div class="p-2 rounded-bottom">
                        <pre class="mt-0 mb-0">{{json_encode($statement['delete_file'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none" data-bs-toggle="collapse" href="#disk_tree" role="button"
               aria-expanded="false" aria-controls="disk_tree">
                <h4 class="mb-0">GET: /api/disk</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Показать все файлы в древовидной структуре
            </p>
            <div class="collapse mb-2" id="disk_tree">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="bg-dark text-white border-bottom rounded-top px-2 pt-1">
                                Response
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark rounded-end rounded-bottom p-2">
                        {{--                        <p class="card-subtitle text-end mb-0">Response</p>--}}
                        <pre class="mt-0 mb-0">{{json_encode($statement['disk_tree'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none" data-bs-toggle="collapse" href="#download_file" role="button"
               aria-expanded="false" aria-controls="download_file">
                <h4 class="mb-0">GET: /api/files</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Скачать файл
            </p>
            <div class="collapse" id="download_file">

                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark  ">
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border overflow-hidden">
                        <div class="card-header bg-white border-bottom border-dark p-2">
                            <p class="mb-0 small"><b>Headers</b></p>
                            <p class="mb-0 small"><i>Authorization:</i> {{$statement['token']}}</p>
                        </div>
                        <div class="p-2 rounded-bottom">
                        <pre class="mt-0 mb-0">{{json_encode($statement['download_file'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none link-success" data-bs-toggle="collapse" href="#share_file" role="button"
               aria-expanded="false" aria-controls="share_file">
                <h4 class="mb-0">POST: /api/files/share</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Создание публичной ссылки на файл
            </p>
            <div class="collapse mb-2" id="share_file">
                <div class="col-auto mb-2">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark  ">
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border overflow-hidden">
                        <div class="card-header bg-white border-bottom border-dark p-2">
                            <p class="mb-0 small"><b>Headers</b></p>
                            <p class="mb-0 small"><i>Authorization:</i> {{$statement['token']}}</p>
                        </div>
                        <div class="p-2 rounded-bottom">
                        <pre class="mt-0 mb-0">{{json_encode($statement['download_file'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="bg-dark text-white border-bottom rounded-top px-2 pt-1">
                                Response
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark rounded-end rounded-bottom p-2">
                        {{--                        <p class="card-subtitle text-end mb-0">Response</p>--}}
                        <pre class="mt-0 mb-0">{{json_encode($statement['shared_file'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none" data-bs-toggle="collapse" href="#download_file_by_public" role="button"
               aria-expanded="false" aria-controls="download_file_by_public">
                <h4 class="mb-0">GET: /api/files/share/c9ab3...</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Скачать по публичной ссылке
            </p>
            <div class="collapse" id="download_file_by_public">

                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark  ">
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border overflow-hidden">
                        <div class="card-header bg-white border-bottom border-dark p-2">
                            <p class="mb-0 small"><b>Headers</b></p>
                            <p class="mb-0 small"><i>Authorization:</i> {{$statement['token']}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-auto col-sm-12">
            <a class="text-decoration-none link-danger" data-bs-toggle="collapse" href="#delete_public_link" role="button"
               aria-expanded="false" aria-controls="delete_public_link">
                <h4 class="mb-0">DELETE: /api/files/share</h4>
            </a>
        </div>
        <div class="col-auto">
            <p class="mb-0">
                Удаление публичной ссылки на файл
            </p>
            <div class="collapse mb-2" id="delete_public_link">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="border-1 border-dark border-top border-start border-end rounded-top px-2 pt-1">
                                Request
                            </div>
                        </div>

                    </div>

                    <div class="text-white bg-dark  ">
                    </div>
                    <div class="border-dark rounded-end rounded-bottom border overflow-hidden">
                        <div class="card-header bg-white border-bottom border-dark p-2">
                            <p class="mb-0 small"><b>Headers</b></p>
                            <p class="mb-0 small"><i>Authorization:</i> {{$statement['token']}}</p>
                        </div>
                        <div class="p-2 rounded-bottom">
                        <pre class="mt-0 mb-0">{{json_encode($statement['delete_file'],
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>--}}
</body>
</html>
