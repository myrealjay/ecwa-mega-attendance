<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HasResponse;

    public function index(Request $request)
    {
        $length = $request->length ?? 10;
        $search = $request->search ?? null;

        $users = User::query()->when(!empty($search), function($query) use($search) {
            return $query->where('first_name', 'LIKE', '%'.$search.'%')
            ->orWhere('last_name', 'LIKE', '%'.$search.'%')
            ->orWhere('email', 'LIKE', '%'.$search.'%')
            ->orWhere('occupation', 'LIKE', '%'.$search.'%')
            ->orWhere('address', 'LIKE', '%'.$search.'%')
            ->orWhere('phone_number', 'LIKE', '%'.$search.'%')
            ->orWhere('dob', 'LIKE', '%'.$search.'%');
        })->paginate($length);

        return $this->successResponse('Users fetched successfully', $users);
    }
}
