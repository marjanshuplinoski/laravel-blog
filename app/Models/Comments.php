<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    //restricts columns from modifying
    protected $guarded = [];

    //user who have commented
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'from_user');
    }

    // returns post of any comment
    public function post()
    {
        return $this->belongsTo('App\Models\Posts', 'on_post');
    }

}
