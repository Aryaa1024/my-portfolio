<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['site_title','site_description','light_logo','dark_logo','light_favicon','dark_favicon'])]
class Setting extends Model
{
    //
}
