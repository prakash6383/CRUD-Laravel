<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trainee;
use App\Models\TechStack;

class TraineeDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:traineeDelete';

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
        
        $inactiveTrainees = TechStack::where('status', 'inactive')->get();
        foreach ($inactiveTrainees as $traineeStack) {
            $traineeStack->delete();
            Trainee::where('id', $traineeStack->trainee_id)->delete();

            info('Trainee has been deleted successfully: ' . $traineeStack->trainee_id);
        }
        return 0;
    }
}
