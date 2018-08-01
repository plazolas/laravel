<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Task;

use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;

class TaskController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @param  User 
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a list of all of the current user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) {
        return view('tasks', [
            'tasks' => $request->user()->tasks
        ]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
            'user_id' => $request->user()->id,
        ]);

        return redirect('/tasks');
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, $id) {
        
        if(is_numeric($id)) {
            $id = intval($id);
        } else {
            $message = __METHOD__."-->Unable to delete non numberic task_id: {$id}";
            Log::info($message);
            return redirect('/tasks');
        }

        $filter = $request->user()->tasks->filter(function($task) use ($id) {
             if($task->id == $id) { 
                 return $task;
             }
        });
        $task = $filter->first();
        $this->authorize('destroy', $task);
        $task->delete();
        $message = __METHOD__."-->Deleted task_id: {$task->id}, name={$task->name}";
        Log::info($message);

        return redirect('/tasks');
    }

}
