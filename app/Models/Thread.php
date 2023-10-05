<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'thread_category_id', 'title'
    ];

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

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->diffForHumans()
        );
    }

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
