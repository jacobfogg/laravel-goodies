<?php namespace Denaje\Extensions\Illuminate\Database;

use Denaje\Extensions\Illuminate\Database\MigrationCreator;
use Denaje\Extensions\Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\MigrationServiceProvider as MSP;

class MigrationServiceProvider extends MSP
{
    protected function registerCreator()
    {
        $this->app->bindShared('migration.creator', function ($app) {
            return new MigrationCreator($app['files']);
        });
    }

    /**
     * Register the migrator service.
     *
     * @return void
     */
    protected function registerMigrator()
    {
        // The migrator is responsible for actually running and rollback the migration
        // files in the application. We'll pass in our database connection resolver
        // so the migrator can resolve any of these connections when it needs to.
        $this->app->singleton('migrator', function ($app) {
            $repository = $app['migration.repository'];

            return new Migrator($repository, $app['db'], $app['files']);
        });
    }
}
