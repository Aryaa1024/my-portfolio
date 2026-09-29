<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id','employment_type','company','role','description','start_date','end_date'])]
class Experience extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
