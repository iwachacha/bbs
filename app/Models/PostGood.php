<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostGood extends Model
{
    use HasFactory;
    
    public function user() {
        return $this->belongsTo(User::class);  
    }
    
    public function post_good() {
        return $this->belongsTo(PostGood::class);  
    }
}
