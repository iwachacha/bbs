<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function lecture() {
        return $this->belongsTo(Lecture::class);
    }
    
    public function review_questions() {
        return $this->hasMany(ReviewQuestion::class);
    }
    
    public function review_goods() {
        return $this->hasMany(ReviewGood::class);  
    }
}
