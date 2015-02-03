<?php namespace Denaje\Extensions\Routing;

use Illuminate\Routing\ControllerServiceProvider as CSP;
use Illuminate\Routing\Console\MakeControllerCommand;
use Denaje\Extensions\Routing\Generators\ControllerGenerator;

class ControllerServiceProvider extends CSP
{
    protected function registerGenerator()
    {
        $this->app->bindShared('command.controller.make', function ($app) {
            // The controller generator is responsible for building resourceful controllers
            // quickly and easily for the developers via the Artisan CLI. We'll go ahead
            // and register this command instances in this container for registration.
            $path = $app['path'].'/controllers';

            $generator = new ControllerGenerator($app['files']);

            return new MakeControllerCommand($generator, $path);
        });
    }
}
