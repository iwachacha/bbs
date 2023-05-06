<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    public function lectures() {
        return $this->hasMany(Lecture::class);  
    }
    
    public function reviews() {
        return $this->hasMany(Review::class);  
    }
    
    public function review_questions() {
        return $this->hasMany(ReviewQuestion::class);  
    }
    
    public function clubs() {
        return $this->hasMany(Club::class);  
    }
    
    public function club_questions() {
        return $this->hasMany(ClubQuestion::class);  
    }
    
    public function topics() {
        return $this->hasMany(Topic::class);  
    }
    
    public function posts() {
        return $this->hasMany(Post::class);  
    }
    
    public function lecture_keeps() {
        return $this->hasMany(LectureKeep::class);  
    }
    
    public function review_goods() {
        return $this->hasMany(ReviewGood::class);  
    }
    
    public function club_keeps() {
        return $this->hasMany(ClubKeep::class);  
    }
    
    public function topic_keeps() {
        return $this->hasMany(ToipcKeep::class);  
    }
    
    public function post_goods() {
        return $this->hasMany(PostGood::class);  
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
