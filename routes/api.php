<?php


use App\Files\Controllers\FileController;
use App\Folders\Controllers\FolderController;
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
Route::get('/greeting', function () {
    return 'Hello World';
});


Route::post('/register', [UserController::class, 'store'])->name('users.store');
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::get('/profile', [UserController::class, 'show'])->middleware('auth.token')->name('users.store');

Route::prefix('/folders')->middleware('auth.token')->group( function(){
    Route::post('', [FolderController::class, 'store'])->name('folder.store');
});

Route::prefix('/files')->middleware('auth.token')->group( function(){
    Route::get('', [FileController::class, 'index'])->name('folder.index');
    Route::post('', [FileController::class, 'store'])->name('folder.store');
    Route::put('', [FileController::class, 'update'])->name('folder.update');
    Route::delete('', [FileController::class, 'destroy'])->name('folder.destroy');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
