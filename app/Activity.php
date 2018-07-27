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
    
    public function user()
    {
        //return $this->hasMany('Larashop\Models\Property', 'foreign_key', 'local_key');
        //return $this->hasMany(PropertyPhotos::class,'LIST_3','property_id');
        return $this->belongsTo('App\User');
    }
}
