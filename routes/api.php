<?php


use App\Files\Controllers\FileController;
use App\Folders\Controllers\FolderController;
use App\Links\Controllers\LinkController;
use App\Users\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [UserController::class, 'store'])->name('users.store');
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::get('/profile', [UserController::class, 'show'])->middleware('auth.token')->name('users.store');

Route::prefix('/folders')->middleware('auth.token')->group( function(){
    Route::post('', [FolderController::class, 'store'])->name('folder.store');
});

Route::prefix('/files')->middleware('auth.token')->group( function(){
    Route::get('', [FileController::class, 'index'])->name('file.index');
    Route::post('', [FileController::class, 'store'])->name('file.store');
    Route::put('', [FileController::class, 'update'])->name('file.update');
    Route::delete('', [FileController::class, 'destroy'])->name('file.destroy');

    Route::get('/download', [FileController::class, 'download'])->name('file.download');
    Route::post('/share', [LinkController::class, 'store'])->name('file.share');
    Route::delete('/share', [LinkController::class, 'destroy'])->name('file.greedy');
});


Route::get('/disk', [FileController::class, 'disk'])->middleware('auth.token');
Route::get('/shared/{link_uuid}', [LinkController::class, 'download'])->name('link.shared');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
