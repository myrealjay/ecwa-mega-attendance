<?php

namespace App\Console\Commands;

use App\Classes\FollowUp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BirthdayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Celebrate members birthdays nd wedding anniversay';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Birthday crone started');
        
        $followUp = new FollowUp();
        $followUp->celebrateBirthday();
        $followUp->celebrateAnniversary();

        Log::info('Birthday crone ended');
    }
}
