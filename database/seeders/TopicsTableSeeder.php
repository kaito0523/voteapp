<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        Topic::create([
            'user_id' => 1,
            'description' => 'あなたが最も好きなプログラミング言語を教えてください。',
            'ends_at' => now()->addDays(7),
        ]);

        Topic::create([
            'user_id' => 1,
            'description' => '来週イベントやるけど参加する？',
            'ends_at' => now()->addDays(5),
        ]);
    }
}
