<?php

namespace App\Console\Commands;

use App\Classes\FollowUp as MyFollowUp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FollowUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check up on members who were absent from service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('FollowUp command started');
        $followUp = new MyFollowUp();
        $followUp->checkUpOnAbsentPeople();
        $followUp->congratulatePresentPeople();
        Log::info('FollowUp command ended');
    }
}
