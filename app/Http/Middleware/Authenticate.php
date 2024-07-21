<?php

namespace App\Http\Middleware;

use App\Traits\HasResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    use HasResponse;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (in_array('auth:sanctum', $request->route()->gatherMiddleware())) {
            return $this->notAuthenticated('Sorry you need to login to proceed');
        }

        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
