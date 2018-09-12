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
Route::get('/', function () { return view('index'); })->name('home');

// Route::get('/', function () { return view('home'); })->name('home');

Route::get('/excel-index', 'ExcelController@index');

Route::post('/excel', 'ExcelController@create')->name('import.file');

Route::get('/users/{userId}/roles/{role}', 'HomeController@roleBasedUser');

Route::get('/users/{userId}', 'HomeController@getUserRole');

Route::post('/role/permission/add', 'HomeController@attachPermission');

Route::get('/role/permission/{roleParam}', 'HomeController@getPermission');

Route::get('/login', function () { return view('login'); })->name('main');

Route::post('/login', 'AuthController@loginIn')->name('login');



Route::get('/author', [
    'uses' => 'HomeController@getAuthorPage',
    'as' => 'author',
    // 'middleware' => 'roles',
    'roles' => ['Admin', 'Author']
]);

Route::get('/admin', [
    'uses' => 'HomeController@getAdminPage',
    'as' => 'admin',
    // 'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::post('/add-new-user', [
    'uses' => 'AuthController@addNewUser',
    'as' => 'add-new-user'
]);
