<?php

namespace App\Classes;

use App\Mail\FollowUpMail;
use App\Models\Attendance;
use App\Models\EmailCategory;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FollowUp
{
    protected $today = '';
    public function __construct()
    {
        $this->today = date('Y-m-d');
    }

    public function checkUpOnAbsentPeople()
    {
        $category = EmailCategory::find(2);

        if(!$category) {
            Log::info("Absent Template category not found");
            return;
        }
        $template = EmailTemplate::where('email_category_id', $category->id)
        ->inRandomOrder()->first();

        if (!$template) {
            Log::info("Absent Template not found");
            return;
        }

        $attendedUsers = Attendance::whereDate('date', $this->today)->pluck('user_id');

        $absentPeople = User::whereNotIn('id', $attendedUsers)->get();
        
        foreach($absentPeople as $absentPerson) {
            try {
                Mail::to($absentPerson->email)->send(new FollowUpMail($absentPerson, $template, 'Absent From Service'));
            } catch(\Exception $e) {
                Log::error($e);
            }
           
        }
    }

    public function congratulatePresentPeople()
    {
        $category = EmailCategory::find(1);

        if(!$category) {
            Log::info("Present Template category not found");
            return;
        }

        $template = EmailTemplate::where('email_category_id', $category->id)
        ->inRandomOrder()->first();

        if (!$template) {
            Log::info("Present Template not found");
            return;
        }

        $attendances = Attendance::with('user')->whereDate('date', $this->today)->get();
        foreach($attendances as $attendance) {
            try {
                Mail::to($attendance->user->email)->send(new FollowUpMail($attendance->user, $template, 'Thank You For Coming'));
            } catch(\Exception $e) {
                Log::error($e);
            }
        }
    }


    public function celebrateBirthday() : void
    {
        $celebrants = User::whereDate('dob', $this->today)->get();
        $celebrantCategory = EmailCategory::find(4);
        $birthdayCategory = EmailCategory::find(3);
        $celebrantTemplate = $celebrantCategory? EmailTemplate::where('email_category_id', $celebrantCategory->id)
            ->inRandomOrder()->first(): null;
        $birthdayTemplate = $birthdayCategory? EmailTemplate::where('email_category_id', $birthdayCategory->id)
            ->inRandomOrder()->first() : null;

        $this->sendCelebrationEmails(
            $celebrants, 
            $celebrantCategory, 
            $birthdayCategory, 
            $celebrantTemplate, 
            $birthdayTemplate,
            'Birthday Celebration'
        );
    }

    public function celebrateAnniversary() : void
    {
        $celebrants = User::whereDate('wedding_date', $this->today)->get();
        $celebrantCategory = EmailCategory::find(6);
        $birthdayCategory = EmailCategory::find(5);
        $celebrantTemplate = $celebrantCategory? EmailTemplate::where('email_category_id', $celebrantCategory->id)
            ->inRandomOrder()->first(): null;
        $birthdayTemplate = $birthdayCategory? EmailTemplate::where('email_category_id', $birthdayCategory->id)
            ->inRandomOrder()->first() : null;

        $this->sendCelebrationEmails(
            $celebrants, 
            $celebrantCategory, 
            $birthdayCategory, 
            $celebrantTemplate, 
            $birthdayTemplate,
            'Wedding Anniversary'
        );
    }

    protected function sendCelebrationEmails(
        $celebrants,
        $celebrantCategory, 
        $birthdayCategory, 
        $celebrantTemplate, 
        $birthdayTemplate,
        $subject
    ) : void
    {
        foreach($celebrants as $celebrant) {
            $users = User::whereNot('id', $celebrant->id)->get();

            //Send to celebrant
            if($celebrantCategory) {
                if ($celebrantTemplate) {
                    try {
                        Mail::to($celebrant->email)->send(new FollowUpMail($celebrant, $celebrantTemplate, $subject));
                    } catch(\Exception $e) {
                        Log::error($e);
                    }
                }
            }

            //Send to other people
            if ($birthdayCategory) {
                if (!$birthdayTemplate) {
                    continue;
                }

                foreach($users as $user) {
                    try {
                        Mail::to($user->email)->send(new FollowUpMail($celebrant, $birthdayTemplate, $subject));
                    } catch(\Exception $e) {
                        Log::error($e);
                    }
                }

            }
            
        }
    }
}
