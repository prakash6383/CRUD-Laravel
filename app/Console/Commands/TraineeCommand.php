<?php

namespace App\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use App\Models\Trainee;
use App\Models\TechStack;

class TraineeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:traineeCreate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $traineeData = Trainee::factory()->raw();
        $techStackData = TechStack::factory()->make()->toArray();
        $data = array_merge($traineeData, $techStackData);
        $trainee = Trainee::create(Arr::only($data, (new Trainee())->getFillable()));
        $stack = new TechStack([
            'name' => $data['name'],
            'status' => $data['status'],
            'trainee_id' => $trainee->id
        ]);
        $stack->save();
    
        if ($trainee) {
            info('Trainee created successfully: ' . $trainee->id);
        }

        return 0;
    }
    
}
