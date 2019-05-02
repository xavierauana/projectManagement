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
            $client = \App\Client::inRandomOrder()->first();
            \App\Project::create([
                'title'      => $faker->sentence(),
                'client_id'  => $client->id,
                'start_date' => $start_date,
                'end_date'   => (new \Carbon\Carbon($start_date))->addDays(rand(10,
                    100)),
            ]);
        }
    }
}
