<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'logo', 'host', 'description'
    ];
    
    /**
     * Get the users for this client.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
    
    /**
    * Get the users for this client.
    */
    public function activities()
    {
        return $this->hasMany('App\Activity');
    }
    
    
}
