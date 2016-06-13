<?php namespace Denaje\Extensions\Illuminate\Foundation\Providers;

use Illuminate\Foundation\Providers\ArtisanServiceProvider as ASP;
use Denaje\Extensions\Illuminate\Foundation\Console\ModelMakeCommand;
use Denaje\Extensions\Illuminate\Routing\Console\ControllerMakeCommand;

class ArtisanServiceProvider extends ASP
{
    protected function registerModelMakeCommand()
    {
        $this->app->singleton('command.model.make', function ($app) {
            return new ModelMakeCommand($app['files']);
        });
    }

    protected function registerControllerMakeCommand()
    {
        $this->app->singleton('command.controller.make', function ($app) {
            return new ControllerMakeCommand($app['files']);
        });
    }
}
