<?php
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
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
//Student Show id
Route::get('/show/{id}', 'StudentController@show');
 

//get all classes
Route::get('/classes', 'ClassesController@index');
/*Route::resource('students', 'StudentController'); */