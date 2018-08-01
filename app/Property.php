<?php

namespace App;

use App\PropertyPhotos;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rets_property_listing_test';
    
    /**
     * Get the photos for this property.
     */
    public function photos()
    {
        //return $this->hasMany('Models\Property', 'foreign_key', 'local_key');
        return $this->hasMany(PropertyPhotos::class,'property_id','LIST_1');
    }
}
