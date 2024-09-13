<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> origin/develop
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
<<<<<<< HEAD
    protected $fillable = ['topic_id', 'text'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function votes()
    {
=======
    protected $fillable = [
        'topic_id',
        'text'
    ];

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function votes(){
>>>>>>> origin/develop
        return $this->hasMany(Vote::class);
    }
}
