<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getAverageRate($request)
    {
        return round(($request->fulfillment_rate + $request->ease_rate + $request->satisfaction_rate) / 3, 2);
    }
}
