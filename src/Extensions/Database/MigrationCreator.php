<?php namespace Denaje\Extensions\Database;

use Illuminate\Database\Migrations\MigrationCreator as MC;

class MigrationCreator extends MC
{
    public function getStubPath()
    {
        return __DIR__.'/stubs';
    }
}
