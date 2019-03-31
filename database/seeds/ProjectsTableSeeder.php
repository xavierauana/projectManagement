<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $start_date = $faker->date('Y/m/d');
            \App\Project::create([
                'title'      => $faker->sentence(),
                'start_date' => $start_date,
                'end_date'   => (new \Carbon\Carbon($start_date))->addDays(rand(10,
                    100)),
            ]);
        }
    }
}
