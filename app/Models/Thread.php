<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Prunable;

class Thread extends Model
{
    use HasFactory, Prunable;

    protected $fillable = [
        'user_id', 'thread_category_id', 'title'
    ];

    //リレーション
    public function thread_category()
    {
        return $this->belongsTo(ThreadCategory::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function latestResponse()
    {
        return $this->hasOne(Response::class)->orderBy('created_at', 'desc');
    }

    //返信が1週間ない雑談部屋は削除
    public function prunable()
    {
        return static::withCount('responses')
            ->where('created_at', '<=', now()->subDays(7))
            ->having('responses_count',  0);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->diffForHumans()
        );
    }

    //検索関連
    public function scopeSearchByTitle($query, $titles = null) //タイトル検索
    {
        if(!empty($titles)){
            foreach($titles as $title) {
                $query->where(function($query) use($title){
                    $query->where('title', 'LIKE', '%'.$title.'%');
                });
            }
        }
    }

    public function scopeSort($query, $sort = null) //並び替え
    {
        if($sort === '古い順'){
            $query->oldest();
        }
        elseif($sort === '会話数(多い順)'){
            $query->orderBy('responses_count', 'desc');
        }
        else {
            $query->latest();
        }
    }

    public function scopeFilter($query, $filter) //絞り込み
    {
        if(!empty($filter)){
            $query->where('thread_category_id', $filter);
        }
    }
}
