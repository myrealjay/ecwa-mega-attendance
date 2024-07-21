<?php

namespace App\Actions\Users;

use App\Contracts\ActionInterface;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;

class RegisterAction implements ActionInterface
{
    use HasResponse;

    protected array $userData;
    protected User $user;

    public function __construct(array $userData)
    {
        if(!empty($userData['dob'])) {
            $userData['dob'] = date('Y-m-d', strtotime($userData['dob']));
        }
        $this->userData = $userData;
    }

    public function execute() : JsonResponse
    {
        $this->userData['password'] = bcrypt(random_int(100000,999999));
        $this->user = User::create($this->userData);

        return $this->loginUser();
    }

    protected function loginUser() : JsonResponse
    {
        $this->user->token = TokenGenerator::new($this->user)->execute();
        return $this->successResponse(
            'User registration was successful, kindly check your mail to verify your account',
            new UserResource($this->user)
        );
    }

    public static function new($userData = null)
    {
        return new self($userData);
    }
}
