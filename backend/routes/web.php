<?php
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
//home or Students list page
Route::get('/', 'StudentController@index');
//Student add page
Route::get('/add', 'StudentController@addstudent');
//Student create
Route::post('/add', 'StudentController@storestudent')->name('store');
//Student edit page
Route::get('/edit/{id}', 'StudentController@editstudent');
//Student update
Route::post('/edit/{id}', 'StudentController@updatestudent')->name('update');
//Student delete
Route::get('/remove/{id}', 'StudentController@deletestudent');


Route::get('/classes', 'ClassesController@index');
//Class add page
Route::get('/addclass', 'ClassesController@addclass');
//Class create
Route::post('/addclass', 'ClassesController@storeclass')->name('storeclass');
//Class edit page
Route::get('/editclass/{id}', 'ClassesController@editclass');
//Class update
Route::post('/editclass/{id}', 'ClassesController@updateclass')->name('updateclass');
//Class delete
Route::get('/removeclass/{id}', 'ClassesController@deleteclass');

//clear config cache
Route::get('/clear-cache', function() {
     Artisan::call('cache:clear');
     Artisan::call('config:clear');
     Artisan::call('config:cache');
     return "Cache is cleared";
 });
