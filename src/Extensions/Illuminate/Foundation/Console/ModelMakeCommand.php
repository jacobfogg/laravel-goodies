<?php namespace Denaje\Extensions\Illuminate\Foundation\Console;

use Illuminate\Foundation\Console\ModelMakeCommand as MMC;

class ModelMakeCommand extends MMC
{
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/model.stub';
    }
}
