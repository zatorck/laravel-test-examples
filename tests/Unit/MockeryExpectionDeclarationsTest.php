<?php

namespace Tests\Unit;

use App\Example\ExampleService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class MockeryExpectionDeclarationsTest
 *
 * @url http://docs.mockery.io/en/latest/reference/expectations.html
 *
 * @package Tests\Unit
 */
class MockeryExpectionDeclarationsTest extends TestCase
{
    /**
     * @return void
     */
    public function testDeclaringMethodCallExpectetions()
    {
        $mock = \Mockery::mock('FooClass');
        $mock->shouldReceive('name_of_method');


        $mock = \Mockery::mock('BarClass');
        $mock->shouldReceive('name_of_method_1', 'name_of_method_2');

        $mock = \Mockery::mock('BassClass');
        $mock->shouldReceive([
            'name_of_method_1' => 'return value 1',
            'name_of_method_2' => 'return value 2',
        ]);

        $mock = \Mockery::mock('MyClass');
        $mock->shouldNotReceive('name_of_method');

        // This generates error
        // $mock->name_of_method();

        $this->assertTrue(true);
    }

    /**
     * @return void
     */
    public function testArgumentMatchingWithClosures()
    {
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('foo')->withArgs(function ($arg, $arg2) {
            if ('ssss' === $arg || 'ssss' === $arg2) {
                return true;
            }

            return false;
        });

        $mock->foo('sssss', 'ssss');

        // Any or no arguments
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->withAnyArgs();

        $mock->name_of_method();
        $mock->name_of_method('fo', 'ba', 'ba');

        //Without arguments
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->withNoArgs();

        // Error below
        // $mock->name_of_method('a');
    }

    /**
     * @return void
     */
    public function testDeclaringReturnValueExpectations()
    {
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->andReturn('simplest');

        $mock->name_of_method(); // 'simplest'

        // It is possible to set up expectation for multiple return values. By providing a sequence of return values, we
        // tell Mockery what value to return on every subsequent call to the method:
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->andReturn('first call', 'second call');

        $mock->name_of_method(); // 'first call'
        $mock->name_of_method(); // 'second call'


        // If we call the method more times than the number of return values we declared, Mockery will return the final
        // value for any subsequent method call:
        $mock = \Mockery::mock('MyClass');

        $mock->shouldReceive('foo')->andReturn(1, 2, 3);

        $mock->foo(); // int(1)
        $mock->foo(); // int(2)
        $mock->foo(); // int(3)
        $mock->foo(); // int(3)


        // The same but other syntax
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->andReturnValues([1, 2, 3]);

        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->andReturnNull();
        // or
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->andReturn([null]);
        // or
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method');

        // With clousers
        // good to know : "We cannot currently mix andReturnUsing() with andReturn()."
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->andReturnUsing(function () {
                func_get_args(); // ['foo', 'bar']
                return 'bas';
            });
        $mock->name_of_method('foo', 'bar'); // 'bas'

        // If we are mocking fluid interfaces, the following method will be helpful:
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->andReturnSelf();
    }

    public function testThrowExceptions()
    {
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->andThrow(new \Exception());

        $this->expectException(\Exception::class);

        $mock->name_of_method();

        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->andThrow(\Exception::class, 'message');

        $this->expectException(\Exception::class);

        $mock->name_of_method();
    }

    public function testSettingPublicProperties()
    {
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('name_of_method')
            ->andSet('foo', 'foo')
            ->andSet('bas', 'bas');

        // Belowline wont work untill you call method
        // $mock->foo;

        // or
        $mock = \Mockery::mock('MyClass');

        $mock->shouldReceive('name_of_method')
            ->set('bar', 'bar');

        $mock->name_of_method();
        $mock->bar;

        /*
       * Pasthru simple saxx if you need to test function with any dependency. I think you shouldn't use it in Laravel
       * You should use partial mockery
       */
        $mock->shouldReceive('name')->passthru()->andReturn('ferrari');

    }

    public function testDeclaringCallCountExpectations()
    {

    }


}
