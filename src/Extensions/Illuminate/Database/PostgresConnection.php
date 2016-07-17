<?php

namespace Denaje\Extensions\Illuminate\Database;

use Illuminate\Database\PostgresConnection as Base;

use Denaje\Extensions\Illuminate\Database\Schema\Grammars\PostgresGrammar as SchemaGrammar;

class PostgresConnection extends Base
{
    /**
     * Get the default schema grammar instance.
     *
     * @return \Illuminate\Database\Schema\Grammars\PostgresGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }
}
