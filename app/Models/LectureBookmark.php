<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Lecture;

class LectureBookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'lecture_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lecture() {
        return $this->belongsTo(Lecture::class);
    }
}