<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name','user_image','rating','comment'])]
class Testimonial extends Model
{
    //
}
