<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\courseController;
use App\Http\Controllers\Admin\TutorialController;





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


Auth::routes();
//view


//Adminpanel
Route::get('/admin/login',[adminController::Class,'index']);
Route::post('/check',[adminController::class,'check'])->name('auth.check');





Route::group(['prefix'=>'admin','middleware'=>['admin'],'namespace'=>'Admin'],function() {
    //adminaccess
    Route::get('/dashboard', [adminController::Class,'dashboard']);
    Route::get('/allcourse', [courseController::Class,'allCourse'])->name('course');
    Route::post('/postcourse', [courseController::Class,'store'])->name('course.post');
    Route::delete('/delete/post/{id}', [courseController::Class,'delete']);
    Route::get('/{id}/edit', [courseController::Class,'edit']);
    Route::post('/{id}/update', [courseController::Class,'update']);

//tutorial
    Route::get('/tutorial', [TutorialController::class,'index'])->name('admin.tutorial');
    Route::get('/admin/addd/tutorial', [TutorialController::class,'tutorialAdd'])->name('admin.addtutorial');
    Route::post('/tutorialpost', [TutorialController::class,'postTutorial'])->name('admin.posttutorial');
    Route::delete('/tutorialpost/{id}', [TutorialController::class,'delete']);

//logout
    Route::get('/logout', [adminController::Class,'logout']);

});


