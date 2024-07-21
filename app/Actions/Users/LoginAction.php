<?php

namespace App\Actions\Users;

use App\Contracts\ActionInterface;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HasResponse;
use Illuminate\Support\Facades\Auth;

class LoginAction implements ActionInterface
{
    use HasResponse;
    protected array $loginData;
    protected User $user;

    public function __construct(array $loginData)
    {
        $this->loginData = $loginData;
    }
    public function execute()
    {
        if (!Auth::attempt($this->loginData)) {
            return $this->notAuthenticated('Invalid login credentials');
        }

        $this->user = auth()->user();
        $this->user->token = TokenGenerator::new($this->user)->execute();

        return $this->successResponse(
            'Login was successful',
            new UserResource($this->user)
        );
    }

    public static function new($loginData = null)
    {
        return new self($loginData);
    }
}
