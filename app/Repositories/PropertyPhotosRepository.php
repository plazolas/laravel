<?php

namespace App\Repositories;

use App\PropertyPhotos;

class PropertyPhotosRepository
{
    /**
     * Get all of the properties for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function myphoto($photo_id)
    {
        return PropertyPhotos::where('photo_id', $photo_id)
                    ->limit(1)
                    ->get();
    }
}
