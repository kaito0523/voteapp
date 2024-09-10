<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'topic_id',
        'text'
    ];

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }
}
