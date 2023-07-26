<?php

namespace App\Models;

use App\Models\FeaturedTours;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favourite extends Model
{
    use HasFactory;
    Protected $with = ["featuredTour"];

    Public function featuredTour(){
        return $this->belongsTo(FeaturedTours::class);
    }
}
