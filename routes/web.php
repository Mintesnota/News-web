<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Route::get('/',[App\Http\Controllers\FrontendController::class,'welcome']);

Route::get('/about', function () {

    return "This is about page";
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware([ 'auth','admin'])->group( function (){


    
Route::get('admin/home',[App\Http\Controllers\AdminController::class,'home']);
Route::get('admin/settings/update', [App\Http\Controllers\AdminController::class,'settingsUpdateForm'])->name('settings.update.form');
Route::post('admin/settings/update', [App\Http\Controllers\AdminController::class,'settingsUpdate'])->name('settings.update');


    //Categories Routes
Route::get('admin/categories', [App\Http\Controllers\AdminController::class,'categories'])->name('admin.categories');
Route::get('admin/category/create', [App\Http\Controllers\AdminController::class,'categoryCreateForm'])->name('admin.category.create.form');
Route::post('admin/category/create', [App\Http\Controllers\AdminController::class,'categorycreate'])->name('admin.category.create');
Route::get('admin/categories/{id}', [App\Http\Controllers\AdminController::class,'categoryUpdateForm'])->name('admin.category.update.form');
Route::post('admin/categories/{id}', [App\Http\Controllers\AdminController::class,'categoryUpdate'])->name('admin.category.update');
Route::get('admin/categories/destroy/{id}', [App\Http\Controllers\AdminController::class,'categoryDestroy'])->name('admin.category.destroy');


//Post Routes
Route::get('admin/posts', [App\Http\Controllers\AdminController::class,'posts'])->name('admin.posts');
Route::get('admin/post/create', [App\Http\Controllers\AdminController::class,'postCreateForm'])->name('admin.post.create.form');
Route::post('admin/post/create', [App\Http\Controllers\AdminController::class,'postcreate'])->name('admin.post.create');
Route::get('admin/posts/{id}', [App\Http\Controllers\AdminController::class,'postUpdateForm'])->name('admin.post.update.form');
Route::post('admin/posts/{id}', [App\Http\Controllers\AdminController::class,'postUpdate'])->name('admin.post.update');
Route::get('admin/posts/destroy/{id}', [App\Http\Controllers\AdminController::class,'postDestroy'])->name('admin.post.destroy');
Route::post('client/ckupload',[App\Http\Controllers\FrontendController::class,'ckupload'])->name('ck.upload');
Route::get('client/post/{id}',[App\Http\Controllers\FrontendController::class,'post'])->name('client.post');
Route::get('/client/category/{id}',[App\Http\Controllers\FrontendController::class,'category'])->name('client.category');


    //Admin event routes
Route::get('admin/events', [App\Http\Controllers\AdminController::class,'events'])->name('admin.events');
Route::get('admin/event/create', [App\Http\Controllers\AdminController::class,'eventCreateForm'])->name('admin.event.create.form');
Route::post('admin/event/create', [App\Http\Controllers\AdminController::class,'eventcreate'])->name('admin.event.create');
Route::get('admin/events/{id}', [App\Http\Controllers\AdminController::class,'eventUpdateForm'])->name('admin.event.update.form');
Route::post('admin/events/{id}', [App\Http\Controllers\AdminController::class,'eventUpdate'])->name('admin.event.update');
Route::get('admin/events/destroy/{id}', [App\Http\Controllers\AdminController::class,'eventDestroy'])->name('admin.event.destroy');


//Video Post routes
Route::get('admin/videos', [App\Http\Controllers\AdminController::class,'videos'])->name('admin.videos');
Route::get('admin/video/create', [App\Http\Controllers\AdminController::class,'videoCreateForm'])->name('admin.video.create.form');
Route::post('admin/video/create', [App\Http\Controllers\AdminController::class,'videocreate'])->name('admin.video.create');
Route::get('admin/videos/{id}', [App\Http\Controllers\AdminController::class,'videoUpdateForm'])->name('admin.video.update.form');
Route::post('admin/videos/{id}', [App\Http\Controllers\AdminController::class,'videoUpdate'])->name('admin.video.update');
Route::get('admin/videos/destroy/{id}', [App\Http\Controllers\AdminController::class,'videoDestroy'])->name('admin.video.destroy');

//Writers request routes
Route::get('admin/writer-requests', [App\Http\Controllers\AdminController::class,'writer_requests'])->name('admin.writer.request');
Route::get('admin/advert-requests', [App\Http\Controllers\AdminController::class,'advertiser_requests'])->name('admin.advert.request');


//User
Route::get('admin/users', [App\Http\Controllers\AdminController::class,'users'])->name('admin.users');
Route::get('admin/writers', [App\Http\Controllers\AdminController::class,'writers'])->name('admin.writers');
Route::get('admin/user/{id}', [App\Http\Controllers\AdminController::class,'profile'])->name('admin.user.profile');
Route::post('admin/users/user/{id}', [App\Http\Controllers\AdminController::class,'updateUser'])->name('admin.user.update');
Route::get('admin/users/user/{id}', [App\Http\Controllers\AdminController::class,'updateUserForm'])->name('admin.user.update.form');
Route::get('admin/users/destroy/{id}', [App\Http\Controllers\AdminController::class,'deleteUser'])->name('admin.user.destroy');
Route::post('admin/user/image/{id}', [App\Http\Controllers\AdminController::class,'updateUserImage'])->name('admin.image.update');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//pages

Route::get('/client/write',[App\Http\Controllers\FrontendController::class,'writeForm'])->middleware('auth')->name('become.writer.form');
Route::post('/client/write/for/us',[App\Http\Controllers\FrontendController::class,'writeForus'])->middleware('auth')->name('become.writer');
Route::get('/client/contact',[App\Http\Controllers\FrontendController::class,'contactForm'])->name('contact.us.form');
Route::post('/client/contact',[App\Http\Controllers\FrontendController::class,'contactus'])->name('contact.us');

Route::get('/client/advertise',[App\Http\Controllers\FrontendController::class,'advertiseForm'])->middleware('auth')->name('advertise.form');
Route::post('/client/advertise/us',[App\Http\Controllers\FrontendController::class,'advertise'])->middleware('auth')->name('advertise');

Route::get('client/about',[App\Http\Controllers\FrontendController::class,'about'])->name('about.us');
Route::get('client/events',[App\Http\Controllers\FrontendController::class,'clientEvents'])->name('client.events');
