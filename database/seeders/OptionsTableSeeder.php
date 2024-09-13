<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionsTableSeeder extends Seeder
{
    public function run()
    {
        Option::create(['topic_id' => 1, 'text' => 'Python']);
        Option::create(['topic_id' => 1, 'text' => 'PHP']);
        Option::create(['topic_id' => 1, 'text' => 'Java']);

        Option::create(['topic_id' => 2, 'text' => 'する']);
        Option::create(['topic_id' => 2, 'text' => 'しない']);
    }   
}
