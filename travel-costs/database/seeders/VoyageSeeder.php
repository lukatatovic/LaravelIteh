<?php

namespace Database\Seeders;

use App\Models\Voyage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoyageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Voyage::truncate();

        Voyage::factory(20)->create();
    }
}
