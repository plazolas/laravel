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
use App\Property;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web', 'auth']], function () {
    
    Route::get('/tasks', function () {
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->get()
        ]);
    });

    Route::post('/tasks/task', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/tasks')
                ->withInput()
                ->withErrors($validator);
        }

        $task = new Task;
        $task->name = $request->name;
        $task->save();

        return redirect('/tasks');
    });

    Route::delete('tasks/task/{id}', function ($id) {
        Task::findOrFail($id)->delete();

        return redirect('/tasks');
    });
    
    Route::get('/properties/id/{id}', ['uses' => 'Property\PropertyController@propertyDetails']);
});

Route::auth();

Route::get('/', ['uses' => 'Property\PropertyController@index']);
Route::get('/home', ['uses' => 'Property\PropertyController@index']);

Route::post('/properties', ['uses' => 'Property\PropertyController@index']);

Route::post('/ajax/get_county', ['uses' => 'Ajax\AjaxController@get_county']);
Route::get('/ajax/get_county', ['uses' => 'Ajax\AjaxController@get_county']);
Route::post('/ajax/get_cities_by_county', ['uses' => 'Ajax\AjaxController@get_cities_by_county']);
Route::get('/ajax/get_cities_by_county', ['uses' => 'Ajax\AjaxController@get_cities_by_county']);
Route::post('/ajax/get_zipcode', ['uses' => 'Ajax\AjaxController@get_zipcode']);
Route::get('/ajax/get_zipcode', ['uses' => 'Ajax\AjaxController@get_zipcode']);
