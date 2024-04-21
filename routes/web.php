<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryTypeController;
use App\Http\Controllers\SubcategoryController;

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

Route::get('/',[ArticleController::class, 'index'])->name('home');

Route::get('/home',[ArticleController::class, 'index'])->name('home');

Route::get('read/{article}', [ArticleController::class, 'show'])->name('read');

Route::post('comment', [CommentController::class, 'store'])->middleware(['auth', 'verified'])->name('comment');

// Route::get('/section', function(){
//     return view('section');
// })->name('section');
Route::get('section/{category}', [ArticleController::class, 'per_category_display'])->name('section');

Route::get('subcategory/{subcategory}', [ArticleController::class, 'per_subcat_display'])->name('subcategory');
//
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('search', [ArticleController::class, 'search_article'])->name('search');

Route::middleware('auth','verified','admin')->group(function(){
    Route::get('/write', [ArticleController::class, 'create'])->name('write');
    Route::get('/edit/{article}', [ArticleController::class, 'edit'])->name('edit');
    Route::get('/delete/{article}', [ArticleController::class, 'destroy'])->name('delete');
    Route::post('save_article', [ArticleController::class, 'store'])->name('save_article');
    Route::post('update_article', [ArticleController::class, 'update'])->name('update_article');
    Route::post('display_article', [ArticleController::class, 'toggle_display'])->name('display_article');
    Route::post('approve_article', [ArticleController::class, 'toggle_approve'])->name('approve_article');
    Route::post('display_carousel', [ArticleController::class, 'display_carousel'])->name('display_carousel');
    Route::post('add_sub_catergory', [SubcategoryController::class, 'store'])->name('add_sub_catergory');
    Route::get('delete_sub_category/{subcategory}', [SubcategoryController::class, 'destroy'])->name('delete_sub_category');
    Route::post('add_category', [CategoryTypeController::class, 'store'])->name('add_category');
    Route::get('/delete_category/{category_type}', [CategoryTypeController::class, 'destroy'])->name('delete_category');
    Route::post('display_category', [CategoryTypeController::class, 'display_catergory'])->name('display_category');
});

Route::middleware('auth')->group(function () {
    Route::get('/account',[AccountController::class, 'verify'])->name('account');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';