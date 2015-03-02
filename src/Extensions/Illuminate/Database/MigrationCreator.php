<?php namespace Denaje\Extensions\Illuminate\Database;

use Illuminate\Database\Migrations\MigrationCreator as MC;

class MigrationCreator extends MC
{
    public function getStubPath()
    {
        return __DIR__.'/stubs';
    }
}
