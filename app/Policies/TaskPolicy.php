<?php

namespace App\Policies;

use App\User;
use App\Task;

use Illuminate\Support\Facades\Log;

use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Determine if the given task can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id || $user->role == 'admin';
    }
    
    /**
     * Determine if the given task can be destroyed by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return bool
     */
    public function destroy(User $user, Task $task)
    {
        return $user->id === $task->user_id || $user->role == 'admin';
    }
}
