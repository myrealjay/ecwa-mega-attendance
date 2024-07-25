<?php

namespace App\Console\Commands;

use App\Classes\FollowUp;
use Illuminate\Console\Command;

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
        $followUp = new FollowUp();
        $followUp->celebrateBirthday();
        $followUp->celebrateAnniversary();
    }
}