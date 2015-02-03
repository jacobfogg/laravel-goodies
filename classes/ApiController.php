<?php

use Denaje\Traits\CasingTrait;
use Illuminate\Support\Contracts\JsonableInterface;
use Illuminate\Support\Contracts\ArrayableInterface;

class ApiController extends Controller
{
    use CasingTrait;

    public static function getJson()
    {
        $input = Input::json()->all();

        // Switch the case
        return static::convertKeysToCase($input, 'snake_case');
    }

    public static function respondOk($object)
    {
        return static::respond(200, $object);
    }

    public static function respondCreated($object)
    {
        return static::respond(201, $object);
    }

    public static function respondNoContent()
    {
        return static::respond(204);
    }

    public static function respondNotFound($object = null)
    {
        return static::respond(404, $object);
    }

    public static function respondUnprocessable()
    {
        return static::respond(422);
    }

    public static function respond($statusCode, $object = null)
    {
        if (is_null($object)) {
            return Response::make(null, $statusCode);
        }

        // Convert the thing in question to an array
        if ($object instanceof ArrayableInterface) {
            $array = $object->toArray();
        } elseif ($object instanceof JsonableInterface) {
            $array = json_decode($object->toJson(), true);
        } elseif (is_object($object)) {
            $array = (array) $object;
        } elseif (is_array($object)) {
            $array = $object;
        } else {
            throw new Exception('Output object not supported!');
        }

        // Switch the case
        $data = static::convertKeysToCase($array, 'camel_case');

        // Return the response
        return Response::json($data, $statusCode);
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this, $method), $parameters);
    }
}
