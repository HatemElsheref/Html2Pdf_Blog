<?php

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

Route::fallback(function (){
    abort(404);
});

Auth::routes(['register'=>false]);

Route::group(['middleware'=>'auth','namespace'=>'Dashboard'],function (){

    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/users/profile','UserController@profile')->name('profile');
    Route::put('/users/profile','UserController@updateprofile')->name('update.profile');
    Route::resource('/users','UserController')->except('show');
    Route::resource('/authors','AuthorController')->except('show');
    Route::resource('/newspapers','NewsPaperController')->except('show');
    Route::resource('/tags','TagController')->except('show');
    Route::resource('/departments','DepartmentController')->except('show');
    Route::post('/articles/upload','ArticleController@upload')->name('articles.upload');
    Route::get('/articles/departments','ArticleController@getDepartments')->name('articles.departments');
    Route::get('/articles/show','ArticleController@show')->name('articles.show');
    Route::resource('/articles','ArticleController')->except('show');

    Route::post('pdf','ArticleController@pdf')->name('pdf');
});
