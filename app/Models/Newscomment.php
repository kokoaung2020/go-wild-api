<?php

namespace App\Models;

use App\Models\Newsreply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Newscomment extends Model
{
    use HasFactory;
    protected $with = ["newsreplies"];

    public function newsreplies(){
        return $this->hasMany(Newsreply::class);
    }
}
