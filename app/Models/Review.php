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
}
