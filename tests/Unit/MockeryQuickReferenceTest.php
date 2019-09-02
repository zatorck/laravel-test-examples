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

    /**
     * @url http://docs.mockery.io/en/latest/getting_started/quick_reference.html#not-so-simple-examples
     *
     * @return void
     */
    public function testNotSoSimpleExamples()
    {
        // Mock object to return a sequence of values
        $mock = \Mockery::mock(array('pi' => 3.1416, 'e' => 2.71));
        $this->assertEquals(3.1416, $mock->pi());
        $this->assertEquals(2.71, $mock->e());

        // Mock object which returns a self-chaining Undefined object for a method call
        $mock = \Mockery::mock('mymock');
        $mock->shouldReceive('divideBy')->with(0)->andReturnUndefined();
        $this->assertTrue($mock->divideBy(0) instanceof \Mockery\Undefined);

        // Creating a mock object with multiple query and single update call
        $mock = \Mockery::mock('db');
        $mock->shouldReceive('query')->between(1, 10)->andReturn(1, 2, 3);
        $mock->shouldReceive('update')->with(5)->andReturn(null)->once();

        $mock->query();
        $mock->query();
        $mock->query();
        $mock->update(5);

        // Expecting all queries to be executed before any updates
        $mock = \Mockery::mock('db');
        $mock->shouldReceive('query')->andReturn(1, 2, 3)->ordered();
        $mock->shouldReceive('update')->andReturn(null)->once()->ordered();

        $mock->update();

        // uncomment next line to fail test
        // $mock->query();

        // Creating a mock object where all queries occur after startup, but before finish, and where queries are
        // expected with several diffrent params

        $db = \Mockery::mock('db');
        $db->shouldReceive('startup')->once()->ordered();

        $db->shouldReceive('query')
            ->with('CPWR')
            ->andReturn(12.3)
            ->once()
            ->ordered('queries'); //  order with group

        $db->shouldReceive('query')
            ->with('MSFT')
            ->andReturn(10.0)
            ->once()
            ->ordered('queries'); //  order with group

        $db->shouldReceive('query')
            ->with(\Mockery::pattern("/^....$/")) // using regrex!
            ->andReturn(3.3)
            ->atLeast() //at least one
            ->once()
            ->ordered('queries');

        $db->shouldReceive('finish')->once()->ordered();

        $db->startup();

        $db->query('CPWR');
        $db->query('DDDD'); // by using group order is not important
        $db->query('DDDD');
        $db->query('MSFT');

        $db->finish();
    }

}
