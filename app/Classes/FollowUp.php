<?php

namespace App\Classes;

use App\Mail\FollowUpMail;
use App\Mail\RecipientMail;
use App\Models\Attendance;
use App\Models\EmailCategory;
use App\Models\EmailTemplate;
use App\Models\Recipient;
use App\Models\SmsTemplate;
use App\Models\User;
use Carbon\Carbon;
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

        $smsTemplate = SmsTemplate::where('email_category_id', $category->id)
        ->inRandomOrder()->first();

        $attendedUsers = Attendance::whereDate('date', $this->today)->pluck('user_id');

        $absentPeople = User::whereNotIn('id', $attendedUsers)->get();
        $smsSender = new SmsSender();
        
        foreach($absentPeople as $absentPerson) {
            if ($smsTemplate) {
                Log::info('Sending text messages to absent people');
                try {
                    $smsSender->send([$absentPerson->phone_number], $smsTemplate, $absentPerson);
                } catch(\Exception $e) {
                    Log::error($e);
                }
            }

            if ($template) {
                Log::info('Sending emails to absent people');
                try {
                    Mail::to($absentPerson->email)->send(new FollowUpMail($absentPerson, $template, 'Absent From Service'));
                } catch(\Exception $e) {
                    Log::error($e);
                }
            }
        }

      $this->notifyRecipients($absentPeople);
    }

    protected function notifyRecipients($absentPeople)
    {
        Log::info('Notifying followup committee');
        $data = "<ul>";
        foreach($absentPeople as $absentPerson) {
            $data .= "<li>{$absentPerson->name} {$absentPerson->phone_number} {$absentPerson->email}</li>";
        }
        $data .= "</ul>";
        
        $recipients = Recipient::with('user')->get();
        foreach($recipients as $recipient) {
            try {
                Mail::to($recipient->user->email)->send(new RecipientMail($data, $recipient->user));
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

        $smsTemplate = SmsTemplate::where('email_category_id', $category->id)
        ->inRandomOrder()->first();

        $smsSender = new SmsSender();

        $attendances = Attendance::with('user')->whereDate('date', $this->today)->get();
        foreach($attendances as $attendance) {
            if ($template) {
                Log::info('Sending text messages to present people');
                try {
                    Mail::to($attendance->user->email)->send(new FollowUpMail($attendance->user, $template, 'Thank You For Coming'));
                } catch(\Exception $e) {
                    Log::error($e);
                }
            }

            if ($smsTemplate) {
                Log::info('Sending emails to present people');
                try {
                    $smsSender->send([$attendance->user->phone_number], $smsTemplate, $attendance->user);
                } catch(\Exception $e) {
                    Log::error($e);
                }
            }
            
        }
    }


    public function celebrateBirthday() : void
    {
        $today = Carbon::today();
        $celebrants = User::whereMonth('dob', $today->month)->whereDay('dob', $today->day)->get();
        $celebrantCategory = EmailCategory::find(4);
        $birthdayCategory = EmailCategory::find(3);

        $this->sendCelebrationEmails(
            $celebrants, 
            $celebrantCategory, 
            $birthdayCategory, 
            'Birthday Celebration'
        );
    }

    public function celebrateAnniversary() : void
    {
        $today = Carbon::today();
        $celebrants = User::whereMonth('wedding_date', $today->month)->whereDay('wedding_date', $today->day)->get();
        $celebrantCategory = EmailCategory::find(6);
        $birthdayCategory = EmailCategory::find(5);
        

        $this->sendCelebrationEmails(
            $celebrants, 
            $celebrantCategory, 
            $birthdayCategory, 
            'Wedding Anniversary'
        );
    }

    protected function sendCelebrationEmails(
        $celebrants,
        $celebrantCategory, 
        $birthdayCategory, 
        $subject
    ) : void
    {
        $smsSender = new SmsSender();
        $celebrantTemplate = $celebrantCategory? EmailTemplate::where('email_category_id', $celebrantCategory->id)
            ->inRandomOrder()->first(): null;
        $birthdayTemplate = $birthdayCategory? EmailTemplate::where('email_category_id', $birthdayCategory->id)
            ->inRandomOrder()->first() : null;

        $celebrantSmsTemplate =  $celebrantCategory ? SmsTemplate::where('email_category_id', $celebrantCategory->id)
        ->inRandomOrder()->first(): null;

        $birthdaySmsTemplate = $birthdayCategory? SmsTemplate::where('email_category_id', $birthdayCategory->id)
            ->inRandomOrder()->first() : null;

        foreach($celebrants as $celebrant) {
            $users = User::whereNot('id', $celebrant->id)->get();

            //Send to celebrant
            if($celebrantCategory) {
                if ($celebrantTemplate) {
                    try {
                        if (!empty($celebrant->email)) {
                            Mail::to($celebrant->email)->send(new FollowUpMail($celebrant, $celebrantTemplate, $subject));
                        }
                    } catch(\Exception $e) {
                        Log::error($e);
                    }
                }

                if ($celebrantSmsTemplate) {
                    try {
                        if (!empty($celebrant->phone_number)) {
                            $smsSender->send([$celebrant->phone_number], $celebrantSmsTemplate, $celebrant);
                        }
                    } catch(\Exception $e) {
                        Log::error($e);
                    }
                }
            }

            //Send to other people
            if ($birthdayCategory) {
                if ($birthdayTemplate) {
                    $emails = $users->pluck('email')->filter(function($email) {
                        return !empty($email);
                    })->values()->toArray();

                    try {
                        Mail::to($emails)->send(new FollowUpMail($celebrant, $birthdayTemplate, $subject));
                    } catch(\Exception $e) {
                        Log::error($e);
                    }
                }

                if ($birthdaySmsTemplate) {
                    $phones = $users->pluck('phone_number')->toArray();
                    try {
                        $smsSender->send($phones, $birthdaySmsTemplate, $celebrant);
                    } catch(\Exception $e) {
                        Log::error($e);
                    }
                }

            }
            
        }
    }
}
