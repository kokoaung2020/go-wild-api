<?php

namespace App\Models;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeaturedTours extends Model
{
    use HasFactory;
    protected $with = ["rating"];

    public function rating(){
        return $this->hasOne(Rating::class);
    }
}
