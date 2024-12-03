<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileManagerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth'])->group(function () {
    // File Manager Routes
    Route::prefix('file-manager')->name('file-manager.')->group(function () {
        Route::get('/', [FileManagerController::class, 'index'])->name('index');
        Route::post('/upload', [FileManagerController::class, 'upload'])->name('upload');
        Route::delete('/delete', [FileManagerController::class, 'delete'])->name('delete');
        Route::post('/create-directory', [FileManagerController::class, 'createDirectory'])->name('create-directory');
        Route::post('/move', [FileManagerController::class, 'move'])->name('move');
    });
});
