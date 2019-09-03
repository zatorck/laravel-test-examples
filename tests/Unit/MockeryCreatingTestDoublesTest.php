<?php

namespace Tests\Unit;

use App\Example\MockAliasExample;
use App\Example\ExampleService;
use App\Example\MockOverloadExample;
use Mockery\Mock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class MockeryCreatingTestDoublesTest
 *
 * @package Tests\Unit
 *
 * @url http://docs.mockery.io/en/latest/reference/creating_test_doubles.html
 */
class MockeryCreatingTestDoublesTest extends TestCase
{
    /**
     * It's common and good practice to name Mocks as classes to autowire etc.
     *
     * @return void
     */
    public function testStubsAndMock()
    {
        $mock = \Mockery::mock('foo'); // foo should be Class name

        $mock = \Mockery::mock(); // it's acceptable but not good practice

        $mock = \Mockery::mock('MyClass'); // recommended way

        $mock = \Mockery::mock('MyInterface'); // also good practice

        $mock = \Mockery::mock('MyClass, MyInterface, OtherInterface'); // it's also good practice

        $this->assertTrue(true);
    }

    /**
     * @url http://docs.mockery.io/en/latest/reference/creating_test_doubles.html#spies
     *
     * @return void
     */
    public function testSpies()
    {
        $spy = \Mockery::spy('MyClass'); // works and ok

        $spy = \Mockery::spy('MyClass, MyInterface, OtherInterface'); // excellent!

        $this->assertTrue(true);

    }

    /**
     * As we can see from this example, with a mock object we set the call expectations before the call itself, and we
     * get the return result we expect it to return. With a spy object on the other hand, we verify the call has
     * happened after the fact. The return result of a method call against a spy is always
     */
    public function testMockVsSpies()
    {
        $mock = \Mockery::mock('MyClass');
        $spy = \Mockery::spy('MyClass');

        $mock->shouldReceive('foo')->andReturn(42);

        $mockResult = $mock->foo(); // int(42)
        $spyResult = $spy->foo(); // null

        $spy->shouldHaveReceived()->foo();
    }

    /**
     * Partial doubles are useful when we want to stub out, set expectations for, or spy on some methods of a class,
     * but run the actual code for other methods.
     */
    public function testPartialTestDoubles()
    {
        // runtime partial test doubles
        $mock = \Mockery::mock(ExampleService::class)->makePartial();

        $mock->giveMeNameBaby(); // ferrari

        $mock->shouldReceive('giveMeNameBaby')->andReturn('aston');

        $mock->giveMeNameBaby(); // aston


        // generated partial test doubles
        // Even though we support generated partial test doubles, we do not recommend using them.
        $foo = \Mockery::mock(ExampleService::class."[giveMeNameBaby]");

        // $foo->giveMeNameBaby(); // error, no expectation set

        $foo->shouldReceive('giveMeNameBaby')->andReturn(456);
        $foo->giveMeNameBaby(); // int(456)

        // setting an expectation for this has no effect
        $foo->shouldReceive('giveMeNameBaby')->andReturn(999);
        $foo->giveMeNameBaby(); // int(456)

        // Theres also Proxied partial test doubles but it simply saxx

    }

    /**
     *  It's used for static public methods, construct are not called
     * "Even though aliasing classes is supported, we do not recommend it."
     */
    public function testAliasMocking()
    {
        $mock = \Mockery::mock('alias:'.MockAliasExample::class);

        // Next line generate error ("no function")
        // MockAliasExample::giveMeAlias();
    }

    /**
     * In diffrence to mockery alias Mockery will generate two __construct's
     * one by default, other to match the interface contains a __construct
     * method youre expecting the newly generated class to implement
     * Mockery test says that it will be usefull in hard dependencies but I think
     * that natvie Laravel mocking is way
     */
    public function testOverloadMocking()
    {
        $mock = \Mockery::mock('overload:'.MockOverloadExample::class);
    }
}
