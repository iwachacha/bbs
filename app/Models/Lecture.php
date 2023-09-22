<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'lecture_category_id', 'faculty_id', 'department_id', 'course_id',
        'lecture_name', 'professor_name', 'season'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function lecture_bookmarks()
    {
        return $this->hasMany(LectureBookmark::class);
    }

    public function bookmarkUsers()
    {
        return $this->belongsToMany(User::class, 'lecture_bookmarks', 'lecture_id', 'user_id')->withTimestamps();
    }

    protected function professorName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strpos($value, "先生") || strpos($value, "さん") || strpos($value, "教授")
                ? $value
                : $value.'先生'
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('Y年m月d日'),
        );
    }
}
