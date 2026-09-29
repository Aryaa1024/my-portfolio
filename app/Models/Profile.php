<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id','title','excerpt','description','official_mobile_code','official_mobile_number','official_email','hero_image','resume_file','linkedin_url','github_url','facebook_url','instagram_url','x_url','youtube_url'])]
class Profile extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
