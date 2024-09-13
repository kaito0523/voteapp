<?php

<<<<<<< HEAD

=======
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> origin/develop
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
<<<<<<< HEAD
    protected $fillable = ['topic_id', 'option_id', 'user_id', 'ip_address'];
=======
    protected $fillable = [
        'topic_id',
        'option_id',
        'user_id',
        'ip_address'
    ];
>>>>>>> origin/develop

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> origin/develop
