<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    public function users() {
        return $this->hasMany(User::class);  
    }
    
    public function department() {
        return $this->belongsTo(Department::class);  
    }
    
    public function lectures() {
        return $this->hasMany(Lecture::class);  
    }
}
