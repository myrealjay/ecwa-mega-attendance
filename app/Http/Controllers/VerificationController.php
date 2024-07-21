<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use HasResponse;
    public function verify($userId, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return $this->failedResponse('Invalid/Expired url provided.');
        }

        $user = User::findOrFail($userId);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect('/verified');
    }
}
