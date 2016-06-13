<?php namespace Denaje\Extensions\Illuminate\Foundation\Providers;

use Illuminate\Support\AggregateServiceProvider;

class ConsoleSupportServiceProvider extends AggregateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        'Denaje\Extensions\Illuminate\Database\MigrationServiceProvider',
        'Denaje\Extensions\Illuminate\Foundation\Providers\ArtisanServiceProvider',

        'Illuminate\Console\ScheduleServiceProvider',
        'Illuminate\Database\SeedServiceProvider',
        'Illuminate\Foundation\Providers\ComposerServiceProvider',
        'Illuminate\Queue\ConsoleServiceProvider',
    ];
}
