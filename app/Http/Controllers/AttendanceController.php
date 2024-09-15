<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\User;
use App\Traits\HasResponse;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    use HasResponse;

    public function index(Request $request)
    {
        $request->validate(['date' => ['required', 'date']]);
        $length = $request->length ?? 20;

        $attendance = Attendance::with('user')->whereDate('date', date('Y-m-d', strtotime($request->date)))->get();

        return $this->successResponse(
            'Attendance fetched successfully', 
            AttendanceResource::collection($attendance)->response()->getData()
        );
    }

    public function store(AttendanceRequest $request)
    {
        $users = $request->users;
        $today = date('Y-m-d');

        Attendance::whereDate('date', $today)->delete();

        foreach($users as $user) {
            Attendance::create([
                'user_id' => $user,
                'date' => $today
            ]);
        }

        return $this->successResponse('Attendeance record saved', []);
    }

    public function attendanceByDate(Request $request)
    {
        $request->validate(['date' => ['required', 'date']]);
        $date = date('Y-m-d', strtotime($request->date));
        $attendedUserIds = Attendance::whereDate('date', $date)->pluck('user_id');

        $present = User::whereIn('id', $attendedUserIds)
        ->orderBy('first_name', 'ASC')->get();
        
        $absent = User::whereNotIn('email', ['superadmin@ecwa.com', 'admin@ecwamegagbagada.com'])
        ->whereNotIn('id', $attendedUserIds)
        ->orderBy('first_name', 'ASC')->get();

        return $this->successResponse('Attendance fetched', [
            'present' => $present,
            'absent' => $absent
        ]);
    }

    public function last4Sundays()
    {
        $sundays = [];
        $date = new DateTime();

        // Find the most recent Sunday
        // if ($date->format('N') != 7) {
        // }

        $date->modify('last Sunday');

        // Add the last 4 Sundays to the array
        for ($i = 0; $i < 4; $i++) {
            $sundays[] = $date->format('Y-m-d');
            $date->modify('-1 week');
        }

        $attendance = Attendance::selectRaw('DATE(date) as date, count(*) as total')
        ->whereIn(DB::raw("DATE(date)"),$sundays)->groupBy('date')->get();

        return $this->successResponse('Attendance statistics fetched', $attendance);
    }

    public function totalPresentLastSunday()
    {
        $date = new DateTime();

        $date->modify('last Sunday');

        $date = $date->format('Y-m-d');
        Log::info($date);

        $attendance = Attendance::selectRaw('DATE(date) as date, count(*) as total')
        ->where(DB::raw("DATE(date)"), $date)->count();

        return $this->successResponse('Attendance statistics fetched', $attendance ?? 0);
    }

    public function totalAbsentLastSunday()
    {
        $date = new DateTime();

        $date->modify('last Sunday');

        $date = $date->format('Y-m-d');

        $attendance = Attendance::where(DB::raw("DATE(date)"), $date)->pluck('user_id');

        $users = User::whereNotIn('id', $attendance ?? 0)
        ->where(function($query) {
            return $query->whereNotIn('email', ['superadmin@ecwa.com', 'admin@ecwamegagbagada.com']);
        })
        ->count();

        return $this->successResponse('Attendance statistics fetched', $users);
    }
}
