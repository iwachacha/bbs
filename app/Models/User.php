<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    
    public function faculty() {
        return $this->belongsTo(Faculty::class);
    }
    
    public function department() {
        return $this->belongsTo(Department::class);
    }
    
    public function course() {
        return $this->belongsTo(Course::class);
    }
    
    public function lectures() {
        return $this->hasMany(Lecture::class);  
    }
    
    public function reviews() {
        return $this->hasMany(Review::class);  
    }
    
    public function lecture_likes() {
        return $this->hasMany(LectureLike::class);  
    }
    
    public function review_goods() {
        return $this->hasMany(ReviewGood::class);  
    }
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'faculty_id',
        'department_id',
        'course_id',
        'grade',
        'comment'
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
