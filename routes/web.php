<?php

use Illuminate\Support\Facades\Auth;
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


/******* TASKS *******/
// Show All Tasks
Route::match(['get', 'post'], '/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Add new Task
Route::get('/add', [App\Http\Controllers\HomeController::class, 'add'])->name('add');
Route::post('/store', [App\Http\Controllers\HomeController::class, 'store'])->name('store');
// Delete Task
Route::get('/delete/{task}', [App\Http\Controllers\HomeController::class, 'destroy'])->name('delete');
// Edit Task
Route::get('/edit_task/{task}', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit');
// Update Task
Route::post('/edit_task/{task}', [App\Http\Controllers\HomeController::class, 'update'])->name('update');
// Restore Task
Route::patch('restore/{task}', [App\Http\Controllers\HomeController::class, 'restore'])->name('restore')->withTrashed();
// routes/web.php

// Filter tasks
Route::post('/tasks/filter', [App\Http\Controllers\HomeController::class, 'filterTasks'])->name('filter');

// Search tasks
Route::post('/tasks/search', [App\Http\Controllers\HomeController::class, 'searchTasks'])->name('search');



/******* Categories *******/
// Show All Tasks
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
// Add new category
Route::post('/store_cat', [App\Http\Controllers\CategoryController::class, 'store'])->name('store_cat');
// Delete Task
Route::get('/delete_cat/{cat}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('delete_cat');
// Edit Category
Route::get('/edit_cat/{cat}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('edit_cat');
// Update Category
Route::post('/edit_cat/{cat}', [App\Http\Controllers\CategoryController::class, 'update'])->name('update_cat');
