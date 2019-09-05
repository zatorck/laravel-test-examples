<?php

namespace Tests\Unit;

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
    }
}
