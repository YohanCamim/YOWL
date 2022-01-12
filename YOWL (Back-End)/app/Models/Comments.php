<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    public $primarykey = 'id';
    protected $fillable = ['content','news_id','author_id','ratingUp', 'ratingDown','parent_id'];

    public function replies() {
        return $this->hasMany('App\Models\Comments', 'parent_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'author_id')->select('id','name');
   }
}
