<?php

namespace Database\Seeders;

use App\Models\Friend;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FriendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Friend::truncate();

        Friend::factory(5)->create();
    }
}
