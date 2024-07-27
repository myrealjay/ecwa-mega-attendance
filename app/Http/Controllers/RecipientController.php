<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    use HasResponse;

    public function index()
    {
        return $this->successResponse('Recipients fetched successfully', Recipient::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'users' => ['required', 'array'],
            'users.*' => ['required', 'exists:users,id']
        ]);

        foreach($request->users as $user) {
            Recipient::firstOrCreate([
                'user_id' => $user
            ]);
        }

        return $this->successResponse('Recipients added successfully', Recipient::all());
    }

    public function delete(Request $request)
    {
        $request->validate([
            'users' => ['required', 'array'],
            'users.*' => ['required', 'exists:users,id']
        ]);

        Recipient::whereIn('id', $request->users)->delete();

        return $this->successResponse('Recipients removed successfully', Recipient::all());
    }
}
