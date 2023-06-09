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
    
    protected $fillable = [
        'user_id', 'lecture_id', 'year', 'class_method', 'attedance', 
        'evaluation_method', 'evaluation_level', 'lecture_level', 'comp_syllabus', 
        'lecture_content', 'title', 'dtail', 'rate_credit', 'rate_adequacy', 'rate_fun'
    ];
}
