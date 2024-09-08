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
        $sort = $request->sort ?? 'first_name';
        $sortDirection = $request->sort_direction ?? 'ASC';

        $users = User::query()->where(function($query) {
            return $query->where('email', '!=' ,'admin@ecwamegagbagada.com')
            ->orWhere('email', null);
        })
            ->when(!empty($search), function($query) use($search) {
            return $query->where('first_name', 'LIKE', '%'.$search.'%')
            ->orWhere('last_name', 'LIKE', '%'.$search.'%')
            ->orWhere('email', 'LIKE', '%'.$search.'%')
            ->orWhere('occupation', 'LIKE', '%'.$search.'%')
            ->orWhere('address', 'LIKE', '%'.$search.'%')
            ->orWhere('phone_number', 'LIKE', '%'.$search.'%')
            ->orWhere('dob', 'LIKE', '%'.$search.'%');
        })
        ->orderBy($sort, $sortDirection)
        ->paginate($length);

        return $this->successResponse('Users fetched successfully', $users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return $this->successResponse('User fetched successfully', $user);
    }

    public function getUserStructure()
    {
        return $this->successResponse('User fetched', User::first());
    }

    public function getUsers()
    {
        $users = User::where(function($query) {
            return $query->where('email', '!=' ,'admin@ecwamegagbagada.com')
            ->orWhere('email', null);
        })->get();
        return $this->successResponse('Users fetched successfully', $users);
    }

    public function count()
    {
        $users = User::where(function($query) {
            return $query->where('email', '!=' ,'admin@ecwamegagbagada.com')
            ->orWhere('email', null);
        })->count();

        return $this->successResponse('user Count fetched successfully', $users);
    }
}
