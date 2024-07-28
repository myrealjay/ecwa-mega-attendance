<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\User;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

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
        
        $absent = User::whereNotIn('id', $attendedUserIds)
        ->orderBy('first_name', 'ASC')->get();

        return $this->successResponse('Attendance fetched', [
            'present' => $present,
            'absent' => $absent
        ]);
    }
}
