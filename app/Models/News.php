<?php

namespace App\Models;

use App\Models\Newsreply;
use App\Models\Newscomment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
    protected $with = ["newscomments"];

    public function newscomments(){
        return $this->hasMany(Newscomment::class);
    }

    // public function newsreplies(){
    //     return $this->hasOneThrough(Newsreply::class,Newscomment::class);
    // }
}
