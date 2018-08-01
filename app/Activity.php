<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rets_property_listing_test';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id','user_id', 'property_id', 'ip', 'description'
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'client_id' => 'int',
        'user_id' => 'int',
        'property_id' => 'int',
    ];
    
    
    
    
    
    
    /**
     * Get the user that owns this activity.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Get the client for this activity.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    
    /**
     * Get the property for this activity.
     */
    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
