<?php

use Jezzdk\Laravel\LaravelRouteGuardServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Mockery\Mock;

class LaravelRouteGuardServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Array
     */
    protected $application_mock = [];

    /**
     * @var ServiceProvider
     */
    protected $service_provider;

    protected function setUp()
    {
        $this->setUpMocks();

        $this->service_provider = new LaravelRouteGuardServiceProvider($this->application_mock);

        parent::setUp();
    }

    protected function setUpMocks()
    {
        $routerMock = Mockery::mock(Router::class);
        $routerMock->shouldReceive('matched')->andReturn(null);

        $this->application_mock = Mockery::mock(ArrayAccess::class);
        $this->application_mock->shouldReceive('offsetGet')->with('router')->andReturn($routerMock);
    }

    /**
     * @test
     */
    public function it_can_be_constructed()
    {
        $this->assertInstanceOf(ServiceProvider::class, $this->service_provider);
    }

    /**
     * @test
     */
    public function it_does_nothing_in_the_register_method()
    {
        $this->assertNull($this->service_provider->register());
    }

    /**
     * @test
     */
    public function it_performs_a_boot_method()
    {
        $this->service_provider->boot();
    }
}
