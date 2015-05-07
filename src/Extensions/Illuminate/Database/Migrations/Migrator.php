<?php namespace Denaje\Extensions\Illuminate\Database\Migrations;

use Illuminate\Database\Migrations\Migrator as M;

class Migrator extends M
{
    protected function runUp($file, $batch, $pretend)
    {
        echo "\033[32mMigrating:\033[m $file\n";

        parent::runUp($file, $batch, $pretend);
    }

    protected function runDown($migration, $pretend = false)
    {
        $file = $migration->migration;

        echo "\033[32mRolling back:\033[m $file\n";

        parent::runDown($migration, $pretend);
    }
}
