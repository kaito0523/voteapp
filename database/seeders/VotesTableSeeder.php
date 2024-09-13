<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vote;

class VotesTableSeeder extends Seeder
{
    public function run(): void
    {
        Vote::create([
            'topic_id' => 1,
            'option_id' => 1,
            'user_id' => 1,
            'ip_address' => '127.0.0.1',
        ]);

        Vote::create([
            'topic_id' => 2,
            'option_id' => 1, 
            'user_id' => 1,
            'ip_address' => '127.0.0.1',
        ]);
    }
}
