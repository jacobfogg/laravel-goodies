<?php namespace Denaje\Extensions\AuthToken;

use Tappleby\AuthToken\AuthTokenServiceProvider as ATSP;
use Tappleby\AuthToken\AuthTokenFilter;
use Denaje\Extensions\AuthToken\AuthTokenManager;
use Denaje\Extensions\AuthToken\AuthTokenController;

class AuthTokenServiceProvider extends ATSP
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->bindShared('tappleby.auth.token', function ($app) {
            return new AuthTokenManager($app);
        });

        $app->bindShared('tappleby.auth.token.filter', function ($app) {
            $driver = $app['tappleby.auth.token']->driver();
            $events = $app['events'];

            return new AuthTokenFilter($driver, $events);
        });

        $app->bind('Tappleby\AuthToken\AuthTokenController', function ($app) {
            $driver = $app['tappleby.auth.token']->driver();
            $credsFormatter = $app['config']->get('laravel-auth-token.format_credentials', null);
            $events = $app['events'];

            return new AuthTokenController($driver, $credsFormatter, $events);
        });
    }
}
