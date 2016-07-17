<?php

namespace Denaje\Extensions\Illuminate\Database\Schema\Grammars;

use Illuminate\Database\Schema\Grammars\PostgresGrammar as Base;

use Illuminate\Support\Fluent;

class PostgresGrammar extends Base
{
    /**
     * Create the column definition for a date-time type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeDateTime(Fluent $column)
    {
        return 'timestamp(6) without time zone';
    }

    /**
     * Create the column definition for a date-time type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeDateTimeTz(Fluent $column)
    {
        return 'timestamp(6) with time zone';
    }

    /**
     * Create the column definition for a time type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeTime(Fluent $column)
    {
        return 'time(6) without time zone';
    }

    /**
     * Create the column definition for a time type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeTimeTz(Fluent $column)
    {
        return 'time(6) with time zone';
    }

    /**
     * Create the column definition for a timestamp type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeTimestamp(Fluent $column)
    {
        if ($column->useCurrent) {
            return 'timestamp(6) without time zone default CURRENT_TIMESTAMP(6)';
        }

        return 'timestamp(6) without time zone';
    }

    /**
     * Create the column definition for a timestamp type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeTimestampTz(Fluent $column)
    {
        if ($column->useCurrent) {
            return 'timestamp(6) with time zone default CURRENT_TIMESTAMP(6)';
        }

        return 'timestamp(6) with time zone';
    }
}
