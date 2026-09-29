<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'email_verified_at', 'mobile_code', 'mobile_number','profile_image', 'mobile_verified_at', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function profile(){
        return $this->hasOne(Profile::class);
    }
    public function qualifications(){
        return $this->hasMany(Qualification::class);
    }
    public function skills(){
        return $this->hasMany(Skill::class);
    }

    public function experiences(){
        return $this->hasMany(Experience::class);
    }
    public function projects(){
        return $this->hasMany(Project::class);
    }
    public function blogs(){
        return $this->hasMany(Blog::class);
    }
    public function services(){
        return $this->hasMany(Service::class);
    }
}
