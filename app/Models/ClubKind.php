<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubKind extends Model
{
    use HasFactory;
    
    public function clubs() {
        return $this->hasMany(Club::class);  
    }
}
