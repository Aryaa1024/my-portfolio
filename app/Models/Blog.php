<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id','title','slug','excerpt','description','featured_image','keywords','status','published_at'])]
class Blog extends Model
{
    protected $casts=[
        'published_at'=>'datetime',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
