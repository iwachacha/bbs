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

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('Y年m月d日'),
        );
    }

    //講義名・教員名検索 exactの値によって部分一致検索と完全一致検索を切り替える
    public function scopeSearchByName($query, $words = null, $exact = null)
    {
        if(!empty($words)){
            foreach($words as $word) {

                if((boolean) $exact){
                    $query->where(function($query) use($word){
                        $query->where('lecture_name', $word)
                            ->orWhere('professor_name', $word);
                    });
                }
                else {
                    $query->where(function($query) use($word){
                        $query->where('lecture_name', 'LIKE', '%'.$word.'%')
                            ->orWhere('professor_name', 'LIKE', '%'.$word.'%');
                    });
                }
            }
        }
    }
}
