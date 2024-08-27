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
        return $this->successResponse(
            'Recipients fetched successfully', 
            Recipient::selectRaw('users.id as user_id, concat(users.first_name," ", users.last_name) as name')
            ->join('users', 'users.id', '=', 'recipients.user_id')->get()->map(function($data) {
                $data['name'] = ucwords($data['name']);
                return $data;
            })
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'users' => ['required', 'array'],
            'users.*' => ['required', 'exists:users,id']
        ]);

        Recipient::query()->delete();

        foreach($request->users as $user) {
            Recipient::firstOrCreate([
                'user_id' => $user
            ]);
        }

        return $this->successResponse(
            'Recipients added successfully', 
            Recipient::with('user:id,first_name,last_name')->get()
        );
    }

    public function delete(Request $request)
    {
        $request->validate([
            'users' => ['required', 'array'],
            'users.*' => ['required', 'exists:users,id']
        ]);

        Recipient::whereIn('user_id', $request->users)->delete();

        return $this->successResponse(
            'Recipients removed successfully', 
            Recipient::with('user:id,first_name,last_name')->get()
        );
    }
}
