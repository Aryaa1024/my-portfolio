<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id','slug','title','excerpt','description','images','live_url'])]
class Project extends Model
{
    protected $casts=[
        'images'=>'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
