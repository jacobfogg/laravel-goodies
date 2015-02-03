<?php namespace Denaje\Extensions\Database;

use Denaje\Extensions\Database\MigrationCreator;
use Illuminate\Database\MigrationServiceProvider as MSP;

class MigrationServiceProvider extends MSP
{
    protected function registerCreator()
    {
        $this->app->bindShared('migration.creator', function ($app) {
            return new MigrationCreator($app['files']);
        });
    }
}
