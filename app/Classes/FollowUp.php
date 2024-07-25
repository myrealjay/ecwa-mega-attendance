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
}
