<?php namespace Denaje\Extensions\Illuminate\Routing\Console;

use Illuminate\Routing\Console\ControllerMakeCommand as CMC;

class ControllerMakeCommand extends CMC
{
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('plain')) {
            return __DIR__.'/stubs/controller.plain.stub';
        }

        return __DIR__.'/stubs/controller.stub';
    }
}
