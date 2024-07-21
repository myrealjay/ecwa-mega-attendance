<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use HasResponse;

    public function index(Request $request)
    {
        $request->validate(['date' => ['required', 'date']]);
        $length = $request->length ?? 20;

        $attendance = Attendance::whereDate('date', date('Y-m-d', strtotime($request->date)))->paginate($length);

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
}
