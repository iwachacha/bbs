<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    
    public function user() {
        return $this->belongsTo(Users::class);  
    }
    
    public function club_questions() {
        return $this->hasMany(ClubQuestion::class);  
    }
    
    public function club_type() {
        return $this->belongsTo(ClubType::class);  
    }
    
    public function club_kind() {
        return $this->belongsTo(ClubKind::class);  
    }
    
    public function club_keeps() {
        return $this->hasMany(ClubKeep::class);  
    }
}
