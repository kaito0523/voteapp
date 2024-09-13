<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
<<<<<<< HEAD
namespace App\Models;

=======
>>>>>>> origin/develop
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

<<<<<<< HEAD
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
=======
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }
}
>>>>>>> origin/develop
