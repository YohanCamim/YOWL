<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikesComments extends Model
{
    use HasFactory;

    protected $fillable = ['comments_id','author_id','type'];
}
