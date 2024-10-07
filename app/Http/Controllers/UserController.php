<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HasResponse;

    /** @var UserService */
    protected UserService $service;

    /**
     * User constructor.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Add user.
     *
     * @param AddUserRequest $request

     * @return JsonResponse
     */
    public function store(AddUserRequest $request): JsonResponse
    {
        $user = $this->service->addUserWithRole($request);

        return $this->successResponse('User added successfully', $user);
    }

    public function index(Request $request)
    {
        $length = $request->length ?? 10;
        $search = $request->search ?? null;
        $sort = $request->sort ?? 'first_name';
        $sortDirection = $request->sort_direction ?? 'ASC';

        $users = User::query()->where(function ($query) {
            return $query->where('email', '!=', 'admin@ecwamegagbagada.com')
                ->orWhere('email', null);
        })
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('occupation', 'LIKE', '%' . $search . '%')
                    ->orWhere('address', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . $search . '%')
                    ->orWhere('dob', 'LIKE', '%' . $search . '%');
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
        $users = User::where(function ($query) {
            return $query->where('email', '!=', 'admin@ecwamegagbagada.com')
                ->orWhere('email', null);
        })->get();
        return $this->successResponse('Users fetched successfully', $users);
    }

    public function count()
    {
        $users = User::where(function ($query) {
            return $query->where('email', '!=', 'admin@ecwamegagbagada.com')
                ->orWhere('email', null);
        })->count();

        return $this->successResponse('user Count fetched successfully', $users);
    }

    /**
     * Fetch roles.
     *
     * @return JsonResponse
     */
    public function getRoles(): JsonResponse
    {
        return $this->successResponse(
            'Roles fetched successfully',
            Role::where('name', '!=', 'Super Admin')->get()
        );
    }

    public function getAdmins(Request $request)
    {
        $length = $request->length ?? 10;
        $search = $request->search ?? null;
        $sort = $request->sort ?? 'first_name';
        $sortDirection = $request->sort_direction ?? 'ASC';

        $users = User::with('roles')->whereHas('roles', function ($query) {
            return $query->where('name', '!=', 'User');
        })
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            })
            ->orderBy($sort, $sortDirection)
            ->paginate($length);

        return $this->successResponse('Admins fetched successfully', $users);
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
        return $this->service->changePassword($request);
    }
}
