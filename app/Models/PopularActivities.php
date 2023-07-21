<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopularActivities extends Model
{
    use HasFactory;
    protected $fillable = ["title","description","link","photo","user_id"];
}
