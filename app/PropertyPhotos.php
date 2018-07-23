<?php

namespace App;

use App\Property;
use Illuminate\Database\Eloquent\Model;

class PropertyPhotos extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rets_property_photos_test';
    
    public function propety()
    {
        //return $this->hasMany('Larashop\Models\Property', 'foreign_key', 'local_key');
        //return $this->hasMany(PropertyPhotos::class,'LIST_3','property_id');
        return $this->belongsTo(Property::class,'property_id');
    }
}
