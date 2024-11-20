<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trainee;
use App\Models\TechStack;

class TraineeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Trainee::factory(50)->create()->each(function ($trainee) {
            TechStack::factory(1)->create([
                'trainee_id' => $trainee->id,
            ]);
        });
    }
}
