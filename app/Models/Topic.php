<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> origin/develop
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
<<<<<<< HEAD
    protected $fillable = ['user_id', 'description', 'ends_at'];
=======
    protected $fillable = [
        'user_id',
        'description',
        'ends_at'
    ];
>>>>>>> origin/develop

    protected $casts = [
        'ends_at' => 'datetime',
    ];

<<<<<<< HEAD
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
=======
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }
}
>>>>>>> origin/develop
