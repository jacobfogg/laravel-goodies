<?php namespace Extensions\Illuminate\Database\Migrations;

use Illuminate\Database\Migrations\Migrator;

class Migrator extends M
{
    protected function runUp($file, $batch, $pretend)
    {
        $this->note("<info>Migrating:</info> $file");

        parent::runUp($file, $batch, $pretend);
    }

    protected function runDown($migration, $pretend = false)
    {
        $file = $migration->migration;

        $this->note("<info>Rolling back:</info> $file");

        parent::runDown($migration, $pretend);
    }
}
