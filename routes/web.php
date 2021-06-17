<?php
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
//clear config cache
Route::get('/clear-cache', function() {
     Artisan::call('cache:clear');
     Artisan::call('config:clear');
     Artisan::call('config:cache');
     return "Cache is cleared";
 });
