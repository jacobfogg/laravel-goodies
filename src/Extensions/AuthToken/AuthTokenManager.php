<?php namespace Denaje\Extensions\AuthToken;

use Tappleby\AuthToken\AuthTokenManager as ATM;
use Denaje\Extensions\AuthToken\AuthTokenDriver;

class AuthTokenManager extends ATM
{
    protected function createDatabaseDriver()
    {
        $provider = $this->createDatabaseProvider();
        $users = $this->app['auth']->driver()->getProvider();

        return new AuthTokenDriver($provider, $users);
    }
}
