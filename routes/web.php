<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('/tasks')->group(function(){
    Route::get('/list', [TaskController::class, 'list'])
        ->name('task_list');
    Route::get('/create', [TaskController::class, 'create'])
        ->name('task_create');
    Route::post('/create', [TaskController::class, 'store'])
        ->name('task.save');
    Route::get('/edit/{id}', [TaskController::class, 'edit'])
        ->name('task.edit');
    Route::post('/update/{id}', [TaskController::class, 'update'])
        ->name('task.update');
    Route::get('/destroy/{id}', [TaskController::class, 'delete'])
        ->name('task.destroy');
    Route::post('/{id}/complete', [TaskController::class, 'complete'])
        ->name('task.complete');



});
