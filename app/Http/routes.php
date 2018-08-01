<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use App\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    });
    Route::post('/logout', function () {
        return redirect('/');
    });
 
    Route::get('/tasks', ['uses' => 'TaskController@index']);
    Route::post('/tasks/task', ['uses' => 'TaskController@store']);
    Route::delete('/tasks/task/{id}', ['uses' => 'TaskController@destroy']);
    //Route::delete('tasks/task/{id}', function ($id) {
    //    Task::findOrFail($id)->delete();
    //    return redirect('/tasks');
    //});
    
    Route::get('/properties/id/{id}', ['uses' => 'Property\PropertyController@propertyDetails']);
});

Route::auth();

Route::get('/', ['uses' => 'Property\PropertyController@index']);
Route::post('/', ['uses' => 'Property\PropertyController@index']);

Route::get('/home', ['uses' => 'Property\PropertyController@index']);
Route::post('/home', ['uses' => 'Property\PropertyController@index']);

Route::get('/properties', ['uses' => 'Property\PropertyController@index']);
Route::post('/properties', ['uses' => 'Property\PropertyController@index']);

Route::post('/ajax/get_county', ['uses' => 'Ajax\AjaxController@get_county']);
Route::get('/ajax/get_county', ['uses' => 'Ajax\AjaxController@get_county']);
Route::post('/ajax/get_cities_by_county', ['uses' => 'Ajax\AjaxController@get_cities_by_county']);
Route::get('/ajax/get_cities_by_county', ['uses' => 'Ajax\AjaxController@get_cities_by_county']);
Route::post('/ajax/get_zipcode', ['uses' => 'Ajax\AjaxController@get_zipcode']);
Route::get('/ajax/get_zipcode', ['uses' => 'Ajax\AjaxController@get_zipcode']);
