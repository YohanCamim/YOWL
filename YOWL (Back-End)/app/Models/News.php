<?php

namespace App\Models;

use App\Models\User;
use App\Models\Likes;
use App\Models\Comments;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'imageUrl', 'url', 'category_id','author_id','ratingUp','ratingDown'];

    public function user(){
         return $this->belongsTo(User::class,'author_id')->select('id','name');
    }

    public function comments(){
        return $this->hasMany(Comments::class,'news_id');
    }
    
}
