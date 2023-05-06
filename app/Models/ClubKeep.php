<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubKeep extends Model
{
    use HasFactory;
    
    public function user() {
        return $this->belongsTo(User::class);  
    }
    
    public function club_keep() {
        return $this->belongsTo(ClubKeep::class);  
    }
}
