<?php

use Carbon\Carbon;
use App\User;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    protected $now;
    private $token;

    public function __construct()
    {
        $this->now = Carbon::now();
    }

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');

        $default = Config::get('database.default');
        $driver = Config::get('database.connections')[$default]['driver'];

        switch ($driver) {
            case 'sqlite':
                break;

            case 'pgsql':
                DB::statement('TRUNCATE users RESTART IDENTITY CASCADE');
                break;
        }

        #DB::beginTransaction();
    }

    public function tearDown()
    {
        parent::tearDown();
        #DB::rollBack();
    }

    protected function callRoute($method, $route, $data = [], $headers = [])
    {
        if (!starts_with($route, '/')) {
            throw new Exception("Hey dummy, you wrote your test wrong! $route should be /$route");
        }

        if ($this->token && !isset($headers['Authorization'])) {
            $headers['HTTP_Authorization'] = "Bearer: $this->token";
        }

        return $this->call(
            $method,
            "/api$route",
            [],
            [],
            [],
            $headers,
            json_encode($data)
        );
    }

    protected function assertOk($response)
    {
        $this->assertEquals(200, $response->getStatusCode());
    }

    protected function assertCreated($response)
    {
        $this->assertEquals(201, $response->getStatusCode());
    }

    protected function assertNoContent($response)
    {
        $this->assertEquals(204, $response->getStatusCode());
    }

    protected function assert400($response)
    {
        $this->assertEquals(400, $response->getStatusCode());
    }

    protected function assertUnauthorized($response)
    {
        $this->assertEquals(401, $response->getStatusCode());
    }

    protected function expectNotFound()
    {
        $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
    }

    protected function assertUnprocessableEntity($response)
    {
        $this->assertEquals(422, $response->getStatusCode());
    }

    protected function assertTeapot($response)
    {
        $this->assertEquals(418, $response->getStatusCode());
    }

    protected function assertJsonResponse($response, $data)
    {
        $this->assertJsonStringEqualsJsonString(json_encode($data), $response->getContent());
    }

    protected function now()
    {
        $this->now->addMinutes(1);
        Carbon::setTestNow($this->now);
        return $this->now->toDateTimeString();
    }

    protected function login($user_id = 1)
    {
        $user = User::find($user_id);
        $this->token = JWTAuth::fromUser($user);

        JWTAuth::setToken($this->token);

        Auth::login($user);
    }
}
