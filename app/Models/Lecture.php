<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Prunable;

class Lecture extends Model
{
    use HasFactory, Prunable;

    protected $fillable = [
        'user_id', 'lecture_category_id', 'faculty_id', 'department_id', 'course_id',
        'lecture_name', 'professor_name', 'season'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lecture_category()
    {
        return $this->belongsTo(LectureCategory::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function lectureBookmarks()
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

    //レビュー投稿が1週間ない講義は削除
    public function prunable()
    {
        return static::withCount('reviews')
            ->where('created_at', '<=', now()->subDays(7))
            ->having('reviews_count',  0);
    }

    //講義名・教員名検索 - exactの値によって部分一致検索と完全一致検索を切り替える
    public function scopeSearchByName($query, $names = null, $exact = null)
    {
        if(!empty($names)){
            foreach($names as $name) {

                if((boolean) $exact){
                    $query->where(function($query) use($name){
                        $query->where('lecture_name', $name)
                            ->orWhere('professor_name', $name);
                    });
                }
                else {
                    $query->where(function($query) use($name){
                        $query->where('lecture_name', 'LIKE', '%'.$name.'%')
                            ->orWhere('professor_name', 'LIKE', '%'.$name.'%');
                    });
                }
            }
        }
    }

    public function scopeSearchByLectureName($query, $name = null)
    {
        if(!empty($name)){
            $query->where('lecture_name', $name);
        }
    }

    public function scopeSearchByProfessorName($query, $name = null)
    {
        if(!empty($name)){
            $query->where('professor_name', $name);
        }
    }

    public function scopeSort($query, $sort = null) //並び替え
    {
        if($sort === 'レビュー数(多い順)'){
            $query->orderBy('reviews_count', 'desc');
        }
        elseif($sort === '保存数(多い順)'){
            $query->orderBy('lecture_bookmarks_count', 'desc');
        }
        elseif($sort === '平均総合評価(高い順)'){
            $query->orderBy('average_rate', 'desc');
        }
        elseif($sort === '平均総合評価(低い順)'){
            $query->orderBy('average_rate', 'asc');
        }
        else {
            $query->latest();
        }
    }

    public function scopeSelectFilter($query, $filter) //絞り込み
    {
        if(!empty($filter['season'])){
            $query->where('season', $filter['season']);
        }

        if(!empty($filter['category'])){
            $query->where('lecture_category_id', (int) $filter['category']);
        }

        if(!empty($filter['faculty'])){
            $query->where('faculty_id', (int) $filter['faculty']);
        }

        if(!empty($filter['department'])){
            $query->where('department_id', (int) $filter['department']);
        }
    }

    public function scopeRatingFilter($query, $filter) //絞り込み
    {
        if(!empty($filter['fulfillment'])){
            $query->havingBetween('fulfillment_rate_avg', [
                (int) $filter['fulfillment'][0],
                (int) $filter['fulfillment'][1]
            ]);
        }

        if(!empty($filter['ease'])){
            $query->havingBetween('ease_rate_avg', [
                (int) $filter['ease'][0],
                (int) $filter['ease'][1]
            ]);
        }

        if(!empty($filter['satisfaction'])){
            $query->havingBetween('satisfaction_rate_avg', [
                (int) $filter['satisfaction'][0],
                (int) $filter['satisfaction'][1]
            ]);
        }
    }
}
