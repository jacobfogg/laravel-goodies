<?php namespace Denaje\Extensions\AuthToken;

use Tappleby\AuthToken\Exceptions\NotAuthorizedException;
use Tappleby\AuthToken\AuthTokenController as ATC;
use Input;
use Validator;
use Denaje\ApiController;

class AuthTokenController extends ATC
{
    public function store()
    {
        $input = Input::json()->all();

        $validator = Validator::make(
            $input,
            array('email' => array('required'), 'password' => array('required'))
        );

        if ($validator->fails()) {
            throw new NotAuthorizedException();
        }

        $creds = call_user_func($this->credentialsFormatter, $input['email'], $input['password']);
        $token = $this->driver->attempt($creds);

        if (!$token) {
            throw new NotAuthorizedException();
        }

        $user = $this->driver->user($token);

        $this->events->fire('auth.token.created', array($user, $token));
        $serializedToken = $this->driver->getProvider()->serializeToken($token);


        return ApiController::respondOk(array('token' => $serializedToken, 'user' => $user->toArray()));
    }
}
