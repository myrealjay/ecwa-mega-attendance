<?php

namespace App\Services;

use App\Events\UserCreated;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Role;
use App\Models\User;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    use HasResponse;

    /** @var User */
    protected User $model;

    /**
     * Constsruct the service.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Create User.
     *
     * @param AddUserRequest $request
     * 
     * @return User
     */
    public function addUserWithRole(AddUserRequest $request): User
    {
        $data = $request->validated();
        $password = Str::random(6);
        $data['password'] = bcrypt($password);

        $user = User::create($data);

        $role = Role::where('name', $data['role'])->pluck('id');

        $user->roles()->attach($role);

        Event::dispatch(new UserCreated($user, $password));

        return $user;
    }

    /**
     * Change password.
     *
     * @param ChangePasswordRequest $request
     * 
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request) : JsonResponse
    {
        $user = Auth::user();
        
        if(!Hash::check($request->old_password, $user->password)){
            return $this->failedResponse('Invalid old login credentials');
        }

        $user->update(['password' => bcrypt($request->password)]);

        return $this->successResponse('Password change was successful', []);
    }
}
