<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewGood extends Model
{
    use HasFactory;
    
    public function user() {
        return $this->belongsTo(User::class);  
    }
    
    public function review_good() {
        return $this->belongsTo(ReviewGood::class);  
    }
}
