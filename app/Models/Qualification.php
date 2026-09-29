<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id','board_or_university','college','course_name','course_start','course_end','type','type_value'])]
class Qualification extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
