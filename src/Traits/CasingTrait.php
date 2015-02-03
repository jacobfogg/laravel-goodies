<?php namespace Denaje\Traits;

trait CasingTrait
{
    /**
     * convertKeysToCase Recursively convert array keys in camelCase with to snake_case
     *
     * @param mixed $input Array of key/value pairs
     * @access private
     * @return array
     */
    private static function convertKeysToCase($input, $case)
    {
        if (is_null($input)) {
            return null;
        }

        // If we are given an object, return an object
        $is_object = is_object($input);

        $return_input = [];

        foreach ($input as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $value = static::convertKeysToCase($value, $case);
            }

            $key = $case($key);
            $return_input[$key] = $value;
        }

        if ($is_object) {
            $return_input = (object) $return_input;
        }

        return $return_input;
    }
}
