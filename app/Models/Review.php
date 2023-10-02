<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'lecture_id', 'title', 'year',
        'fulfillment_rate', 'ease_rate', 'satisfaction_rate', 'average_rate',
        'good_point', 'bad_point', 'lecture_content'
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function review_good()
    {
        return $this->hasOne(ReviewGood::class);
    }

    public function getAverageRate($request)
    {
        return round(($request->fulfillment_rate + $request->ease_rate + $request->satisfaction_rate) / 3, 2);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('Y年m月d日'),
        );
    }

    public function scopeSearchByWord($query, $words = null) //キーワード検索
    {
        if(!empty($words)){
            foreach($words as $word) {
                $query->where(function($query) use($word){
                    $query->where('title', 'LIKE', '%'.$word.'%')
                        ->orWhere('lecture_content', 'LIKE', '%'.$word.'%')
                        ->orWhere('good_point', 'LIKE', '%'.$word.'%')
                        ->orWhere('bad_point', 'LIKE', '%'.$word.'%');
                });
            }
        }
    }

    public function scopeSearchByTag($query, $tag = null) //#タグ検索
    {
        if(!empty($tag)){
            $query->WhereHas('tags', function ($query) use ($tag) {
                $query->where('name', $tag);
            });
        }
    }

    public function scopeSort($query, $sort = null) //並び替え
    {
        if($sort === '充実度評価(高い順)'){
            $query->orderBy('fulfillment_rate', 'desc');
        }
        elseif($sort === '充実度評価(低い順)'){
            $query->orderBy('fulfillment_rate', 'asc');
        }
        elseif($sort === '楽単度評価(高い順)'){
            $query->orderBy('ease_rate', 'desc');
        }
        elseif($sort === '楽単度評価(低い順)'){
            $query->orderBy('ease_rate', 'asc');
        }
        elseif($sort === '満足度評価(高い順)'){
            $query->orderBy('satisfaction_rate', 'desc');
        }
        elseif($sort === '満足度評価(低い順)'){
            $query->orderBy('satisfaction_rate', 'asc');
        }
        else {
            $query->latest();
        }
    }

    public function scopeFilter($query, $filter) //絞り込み
    {
        if(!empty($filter['fulfillment'])){
            $query->whereBetween('fulfillment_rate', [
                (int) $filter['fulfillment'][0],
                (int) $filter['fulfillment'][1]
            ]);
        }

        if(!empty($filter['ease'])){
            $query->whereBetween('ease_rate', [
                (int) $filter['ease'][0],
                (int) $filter['ease'][1]
            ]);
        }

        if(!empty($filter['satisfaction'])){
            $query->whereBetween('satisfaction_rate', [
                (int) $filter['satisfaction'][0],
                (int) $filter['satisfaction'][1]
            ]);
        }

        if(!empty($filter['year'])){
            $query->whereBetween('year', [
                (int) $filter['year'][0],
                (int) $filter['year'][1]
            ]);
        }
    }
}
