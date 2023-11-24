<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $NUMBER_OF_JOBS = 10;

        for ($i = 0; $i < $NUMBER_OF_JOBS; $i++) {
            Job::create([
                'title' => $faker->jobTitle,
                'description' => $faker->paragraph,
            ]);
        }
    }
}
