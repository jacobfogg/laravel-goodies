<?php namespace Denaje\Extensions\AuthToken;

use Tappleby\AuthToken\AuthTokenDriver as ATD;
use Illuminate\Auth\UserInterface;

/**
 * AuthTokenDriver
 *
 * https://github.com/sahusoftcom/laravel-auth-token/commit/8698b8f04579e93089bdadff95fb97ee4a33728e
 */
class AuthTokenDriver extends ATD
{
    public function create(UserInterface $user)
    {
        //$this->tokens->purge($user);
        return $this->tokens->create($user);
    }
}
