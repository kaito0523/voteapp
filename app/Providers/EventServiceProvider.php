<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // イベントとリスナーのマッピングをここに追加します
    ];

    public function boot()
    {
        parent::boot();
    }
}