<?php

namespace App;

use App\Task;
use App\Activity;
use App\Client;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id','name', 'email', 'phone', 'role', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];
    
    /**
     * Get the client for this user.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get all of the tasks for the user.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
    /**
     * Get all of the activities for the user.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
