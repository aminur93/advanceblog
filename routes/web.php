<?php

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

Route::get('/',[
  'uses' => 'BlogController@index',
  'as' => 'blogs'
]);

Route::get('/blog/{post}', [
  'uses' => 'BlogController@show',
  'as' => 'blogs.show'
]);

Route::get('/category/{category}',[
    'uses' => 'BlogController@category',
    'as' => 'category'
]);

Route::post('/blog/{post}/comments', [
    'uses' => 'CommentsController@store',
    'as' => 'blog.comments'
]);

Route::get('/author/{author}',[
    'uses' => 'BlogController@author',
        'as' => 'author'
    ]);
Route::get('/tag/{tag}',[
    'uses' => 'BlogController@tag',
    'as' => 'tag'
]);
Auth::routes();

Route::get('/home', 'Backend\HomeController@index')->name('home');
Route::get('/home/error', 'Backend\HomeController@error')->name('home.error');
Route::get('/edit-account','Backend\HomeController@edit');
Route::put('/edit-account','Backend\HomeController@update');

Route::put('/backend/blog/restore/{blog}',[
    'uses' => 'Backend\BlogController@restore',
    'as' => 'backend.blog.restore'
]);

Route::delete('/backend/blog/force-destroy/{blog}',[
    'uses' => 'Backend\BlogController@forceDestroy',
    'as' => 'backend.blog.force-destroy'
]);

Route::resource('/backend/blog', 'Backend\BlogController');

Route::resource('/backend/categories', 'Backend\CategoryController');

Route::resource('/backend/users', 'Backend\UsersController');

Route::get('/backend/users/confirm/{users}',[
    'uses' => 'Backend\UsersController@confirm',
    'as' => 'backend.users.confirm'
]);

