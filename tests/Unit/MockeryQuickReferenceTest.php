<?php

namespace Tests\Unit;

use App\Example\ExampleService;
use App\Example\ExampleTwoService;
use App\Example\Temperature;
use App\Example\TemperatureInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * Class MockeryQuickReferenceTest
 *
 * @url http://docs.mockery.io/en/latest/getting_started/quick_reference.html
 *
 * @package Tests\Unit
 */
class MockeryQuickReferenceTest extends TestCase
{

    /**
     * @return void
     */
    public function testQuickReferenceExamplePartOne()
    {
        // Creating test double
        \Mockery::mock(Temperature::class);

        // Creating test double implementing interface
        $mock = \Mockery::mock(Temperature::class, TemperatureInterface::class);


        $mock->shouldReceive('average')
            ->once() // this is assertion! It check if function is called
            ->with(1) // this is also assertion - check if given parameters are good
            ->andReturn(10); // this is not assertion


        $exampleTwoService = new ExampleTwoService($mock);

        $exampleTwoService->getTemp();
    }

    /**
     * @return void
     */
    public function testQuickReferenceExamplePartTwo()
    {
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('foo')
            ->andReturn(1, 2, 3);

        $mock->foo(); // int(1);
        $mock->foo(); // int(2);
        $mock->foo(); // int(3);
        $mock->foo(); // int(3);
    }

    /**
     * @return void
     */
    public function testQuickReferenceExamplePartThree()
    {
        //Set mock to defer unexpected methods to its parent if possible
        $mock = \Mockery::mock(ExampleService::class)->makePartial();

        $mock->giveMeNameBaby();

        $spy = \Mockery::spy('MyClass'); // notice that when we change spy for mock
                                                // test in next lin fails because of not using should recive

        $spy->foo(); // in this place we use function

        $spy->shouldHaveReceived()->foo(); // assertion by spy
    }
}
