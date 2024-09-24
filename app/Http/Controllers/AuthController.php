<?php

namespace App\Http\Controllers;

use App\Actions\Users\LoginAction;
use App\Actions\Users\RegisterAction;
use App\Actions\Users\TokenGenerator;
use App\Classes\FileHandler;
use App\Http\Requests\ClientRegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetLinkRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use HasResponse;

    protected User $user;

    public function register(RegisterRequest $request) : JsonResponse
    {
        $handler = new FileHandler();
        $data = $request->validated();
        if (!empty($request->file('picture'))) {
            $picture = $request->file('picture');
            $fileName = $picture->getClientOriginalName();
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = $handler->getFileName().'.'.$extension;
            $picture = $handler->upload('images', $newFileName, $picture, 'local');
            $data['picture'] = $picture;
        }

        return RegisterAction::new($data)->execute();
    }

    public function update(UpdateUserRequest $request, int $userId)
    {
        $user = User::findOrFail($userId);

        $user->update($request->validated());

        return $this->successResponse('User Updatd successfully', $user);
    }

    public function login(LoginRequest $request)
    {
        return LoginAction::new($request->validated())->execute();
    }

    public function refresh()
    {
        $this->user = auth()->user();
        $this->user->token = TokenGenerator::new($this->user)->execute();

        return $this->successResponse(
            'Login was successful',
            new UserResource($this->user)
        );
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse('Logout was successful', []);
    }

    public function sendResetLink(ResetLinkRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $this->successResponse('If your email exists with us then you should have received an email, kindly check your mail', []);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
       if ( $status !== Password::PASSWORD_RESET ){
        return $this->failedResponse(__($status), []);
       }
    
       return $this->successResponse('Your password was successfully reset', []);
    }
}
