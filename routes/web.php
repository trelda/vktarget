<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['namespace' => '\App\Http\Controllers\User', 'middleware' => 'auth'], function() {
    Route::get('/users', [App\Http\Controllers\User\IndexController::class, '__invoke'])->name('user.index');
    Route::get('/users/{user}', [App\Http\Controllers\User\EditController::class, '__invoke'])->name('user.edit');
    Route::patch('/users/{user}', [App\Http\Controllers\User\UpdateController::class, '__invoke'])->name('user.update');
    Route::delete('/users/{user}/delete', [App\Http\Controllers\User\DestroyController::class, '__invoke'])->name('user.delete');
});

Route::group(['namespace' => '\App\Http\Controllers\Network', 'middleware' => ['auth', 'token']], function() {
    Route::get('/networks/export', [\App\Http\Controllers\Network\ExportController::class, 'export'])->name('network.export');
    Route::get('/networks', [App\Http\Controllers\Network\IndexController::class, '__invoke'])->name('network.index');
    Route::get('/network', [App\Http\Controllers\Network\CreateController::class, '__invoke'])->name('network.create');
    Route::post('/network', [App\Http\Controllers\Network\StoreController::class, '__invoke'])->name('network.store');
    Route::get('/networks/{network}', [App\Http\Controllers\Network\EditController::class, '__invoke'])->name('network.edit');
    Route::patch('/networks/{network}', [App\Http\Controllers\Network\UpdateController::class, '__invoke'])->name('network.update');
    Route::delete('/networks/{network}/delete', [App\Http\Controllers\Network\DestroyController::class, '__invoke'])->name('network.delete');

    Route::get('/loms', [App\Http\Controllers\Lom\IndexController::class, '__invoke'])->name('lom.index');
    Route::get('/loms/export', [\App\Http\Controllers\Lom\ExportController::class, 'export'])->name('lom.export');
    Route::get('/lom', [App\Http\Controllers\Lom\CreateController::class, '__invoke'])->name('lom.create');

    Route::post('/lom', [App\Http\Controllers\Lom\StoreController::class, '__invoke'])->name('lom.store');
    Route::get('/loms/{lom}', [App\Http\Controllers\Lom\EditController::class, '__invoke'])->name('loms.edit');
    Route::patch('/loms/{lom}', [App\Http\Controllers\Lom\UpdateController::class, '__invoke'])->name('lom.update');
    Route::delete('/loms/{lom}/delete', [App\Http\Controllers\Lom\DestroyController::class, '__invoke'])->name('loms.delete');

    Route::get('/posts', [App\Http\Controllers\Post\IndexController::class, '__invoke'])->name('post.index');
});

Route::group(['namespace' => '\App\Http\Controllers\LomPost', 'middleware' => ['auth', 'token']], function() {
    Route::get('/lomposts', [App\Http\Controllers\LomPost\IndexController::class, '__invoke'])->name('lompost.index'); 
    Route::get('/lompost', [App\Http\Controllers\LomPost\CreateController::class, '__invoke'])->name('lompost.create');
    Route::post('/lompost', [App\Http\Controllers\LomPost\StoreController::class, '__invoke'])->name('lompost.store');
    Route::post('/lomposts/export', [\App\Http\Controllers\LomPost\ExportController::class, '__invoke'])->name('lompost.export');

});