<?php namespace Denaje\Extensions\Illuminate\Routing;

use Illuminate\Routing\GeneratorServiceProvider as GSP;
use Denaje\Extensions\Illuminate\Routing\Console\ControllerMakeCommand;

class GeneratorServiceProvider extends GSP
{
    /**
     * Register the controller generator command.
     *
     * @return void
     */
    protected function registerControllerGenerator()
    {
        $this->app->singleton('command.controller.make', function ($app) {
            return new ControllerMakeCommand($app['files']);
        });
    }
}
