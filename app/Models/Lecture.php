<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function reviews() {
        return $this->hasMany(Review::class);
    }
    
    public function lecture_category() {
        return $this->belongsTo(LectureCategory::class);
    }
    
    public function faculty() {
        return $this->belongsTo(Faculty::class);
    }
    
    public function department() {
        return $this->belongsTo(Department::class);
    }
    
    public function course() {
        return $this->belongsTo(Course::class);
    }
    
    public function lecture_keeps() {
        return $this->hasMany(LectureKeep::class);  
    }
    
}
