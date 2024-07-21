<?php

namespace App\Actions\Users;

use App\Contracts\ActionInterface;
use App\Models\User;

class TokenGenerator implements ActionInterface
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function execute()
    {
        return $this->cleanBearerToken(
            $this->user->createToken('login token')->plainTextToken
        );
    }

    /**
    * Returns sanctum API token without default user token number and slash(|)
    * example 12|hfhfhhfhfhfh returns hfhfhhfhfhfh
    * @param string $token
    * @return string
    */
    protected function cleanBearerToken($token)
    {
        return (explode('|', $token))[1];
    }

    public static function new($data = null)
    {
        return new self($data);
    }
}