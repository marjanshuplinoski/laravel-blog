<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    //restricts columns from modifying
    protected $guarded = [];

    // posts has many comments
    // returns all comments on that post
    public function comments()
    {
        return $this->hasMany('App\Models\Posts', 'on_post');
    }

    // returns the instance of the user who is author of that post
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }

}