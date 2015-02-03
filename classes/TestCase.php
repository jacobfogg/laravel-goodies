<?php

use Carbon\Carbon;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    protected $now;

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
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__.'/../../bootstrap/start.php';
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

        DB::beginTransaction();
    }

    public function tearDown()
    {
        parent::tearDown();
        DB::rollBack();
    }

    protected function callRoute($method, $route, $data = [], $headers = [])
    {
        if (!starts_with($route, '/')) {
            throw new Exception("Hey dummy, you wrote your test wrong! $route should be /$route");
        }

        return $this->call(
            $method,
            "/api$route",
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

    protected function expectUnauthorized()
    {
        $this->setExpectedException('AuthTokenNotAuthorizedException');
    }

    protected function expectNotFound()
    {
        $this->setExpectedException('ModelNotFoundException');
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
        $this->be(User::find($user_id));
    }
}
