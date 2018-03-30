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
use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {
    /**
     * Show Task Dashboard
     */
    
    Route::get('/', function () {
        return redirect('/home');
    })->middleware('auth');
    
    Route::get('/tasks', function () {
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->get()
        ]);
    })->middleware('auth');

    /**
     * Add New Task
     */
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
    })->middleware('auth');

    /**
     * Delete Task
     */
    Route::delete('tasks/task/{id}', function ($id) {
        Task::findOrFail($id)->delete();

        return redirect('/tasks');
    })->middleware('auth');
});

Route::auth();

Route::get('/home', 'HomeController@index');
