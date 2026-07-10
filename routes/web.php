<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Pages\PagesController;
use App\Http\Controllers\Pages\UsersController;
use App\Http\Controllers\Api\UsersApiController;
use App\Http\Controllers\Pages\BlogCategoryController;
use App\Http\Controllers\Pages\BlogPostController;
use App\Http\Controllers\Pages\LanguageController;
use App\Http\Controllers\Public\BlogController;


Route::get('/', [AuthController::class, 'home']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/api/login',[AuthApiController::class,'login']);
Route::post('/api/register',[AuthApiController::class,'register']);
Route::get('/dashboard', [PagesController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/upgrade', [PagesController::class, 'upgrade'])->middleware('auth')->name('upgrade');
Route::get('/admin/profile', [PagesController::class, 'profile'])->middleware('auth')->name('profile');
Route::post('/admin/profile/update', [PagesController::class, 'updateProfile'])->middleware('auth')->name('profile.update');

// Users Routes
Route::get('/users', [UsersController::class, 'index'])->middleware('auth')->name('users');
Route::post('/api/users/getData',[UsersController::class,'getData'])->middleware('auth');
Route::get('/users/new',[UsersController::class,'new'])->middleware('auth')->name('users/new');
Route::post('/api/users/saveUser',[UsersController::class,'saveUser'])->middleware('auth');

Route::get('/users/edit/{param}',[UsersController::class,'edit'])->middleware('auth')->name('users/edit');
Route::post('/api/users/deleteUser',[UsersController::class,'deleteUser'])->middleware('auth');

// Blog Categories Routes (Admin)
Route::get('/admin/blog-categories', [BlogCategoryController::class, 'index'])->middleware('auth')->name('blog-categories');
Route::post('/api/blog-categories/getData', [BlogCategoryController::class, 'getData'])->middleware('auth');
Route::get('/admin/blog-categories/new', [BlogCategoryController::class, 'new'])->middleware('auth')->name('blog-categories.new');
Route::get('/admin/blog-categories/edit/{param}', [BlogCategoryController::class, 'edit'])->middleware('auth')->name('blog-categories.edit');
Route::post('/api/blog-categories/saveCategory', [BlogCategoryController::class, 'saveCategory'])->middleware('auth');
Route::post('/api/blog-categories/deleteCategory', [BlogCategoryController::class, 'deleteCategory'])->middleware('auth');

// Blog Posts Routes (Admin)
Route::get('/admin/blog-posts', [BlogPostController::class, 'index'])->middleware('auth')->name('blog-posts');
Route::post('/api/blog-posts/getData', [BlogPostController::class, 'getData'])->middleware('auth');
Route::get('/admin/blog-posts/new', [BlogPostController::class, 'new'])->middleware('auth')->name('blog-posts.new');
Route::get('/admin/blog-posts/preview/{id}', [BlogPostController::class, 'preview'])->middleware('auth')->name('blog-posts.preview');
Route::get('/admin/blog-posts/edit/{param}', [BlogPostController::class, 'edit'])->middleware('auth')->name('blog-posts.edit');
Route::post('/api/blog-posts/savePost', [BlogPostController::class, 'savePost'])->middleware('auth');
Route::post('/api/blog-posts/toggleStatus', [BlogPostController::class, 'toggleStatus'])->middleware('auth');
Route::post('/api/blog-posts/deletePost', [BlogPostController::class, 'deletePost'])->middleware('auth');

// Languages Routes (Admin)
Route::get('/admin/languages', [LanguageController::class, 'index'])->middleware('auth')->name('languages');
Route::post('/api/languages/toggleStatus', [LanguageController::class, 'toggleStatus'])->middleware('auth');
Route::post('/api/languages/saveLanguage', [LanguageController::class, 'saveLanguage'])->middleware('auth');
Route::post('/api/languages/deleteLanguage', [LanguageController::class, 'deleteLanguage'])->middleware('auth');

// Settings Routes (Admin)
Route::get('/admin/settings', [\App\Http\Controllers\Pages\SettingsController::class, 'index'])->middleware('auth')->name('settings');
Route::post('/admin/settings/save', [\App\Http\Controllers\Pages\SettingsController::class, 'save'])->middleware('auth')->name('settings.save');

// Pages Routes (Admin)
Route::get('/admin/pages', [\App\Http\Controllers\Pages\SitePageController::class, 'index'])->middleware('auth')->name('pages.index');
Route::get('/admin/pages/form/{id?}', [\App\Http\Controllers\Pages\SitePageController::class, 'form'])->middleware('auth')->name('pages.form');
Route::post('/admin/pages/save', [\App\Http\Controllers\Pages\SitePageController::class, 'save'])->middleware('auth')->name('pages.save');
Route::get('/admin/pages/delete/{id}', [\App\Http\Controllers\Pages\SitePageController::class, 'delete'])->middleware('auth')->name('pages.delete');

// Media Routes (Admin)
Route::get('/admin/media', [\App\Http\Controllers\Pages\MediaController::class, 'index'])->middleware('auth')->name('media');
Route::get('/admin/media/list', [\App\Http\Controllers\Pages\MediaController::class, 'list'])->middleware('auth')->name('media.list');
Route::post('/admin/media/upload', [\App\Http\Controllers\Pages\MediaController::class, 'upload'])->middleware('auth')->name('media.upload');
Route::post('/admin/media/delete', [\App\Http\Controllers\Pages\MediaController::class, 'delete'])->middleware('auth')->name('media.delete');

// Public Page Route
Route::get('/page/{slug}', [\App\Http\Controllers\Pages\SitePageController::class, 'show'])->name('page.show');

// Public Blog Routes
Route::get('/lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'detail'])->name('blog.detail');
