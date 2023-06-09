<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    
    public function users() {
        return $this->hasMany(User::class);  
    }
    
    public function departments() {
        return $this->hasMany(Department::class);  
    }
    
    public function lectures() {
        return $this->hasMany(Lecture::class);  
    }
}
