<?php

namespace Tests\Feature;

use App\Example\ExampleTwoService;
use Tests\TestCase;
use Mockery;
use App\Example\ExampleService;

/**
 * Class MockeryTest
 *
 * @url https://laravel.com/docs/5.8/mocking
 *
 * @package Tests\Feature
 */
class MockeryTest extends TestCase
{

    /**
     * NO 1. Mocking object part.1
     *
     * This example basics on laravel docs + method and Return. It can be used
     * for example to mock Rest API Clients, but I found very good sentece about mocks:
     * "Mock objects are useful when verifying that a method was called
     * is more important than verifying the outcome of calling that method"
     *
     * Of course thats mean that when you comment lines 39-45 test will fail
     *
     * Doc for Mockery Library: http://docs.mockery.io/en/latest/
     */
    public function testMockingObject()
    {

        $this->instance(ExampleService::class, Mockery::mock(ExampleService::class, function ($mock) {
            $mock->shouldReceive('giveMeNameBaby')->andReturn('martin')->once();
        }));

        $response = $this->json('POST', '/testService');

        $response
            ->assertExactJson(
                ['name' => 'martin']
            );

    }

    /**
     * NO 2. Mocking object part.2
     *
     * This is simalar example to first but in more convenient
     * way, provided by Laravel base tast class
     */
    public function testMockingObjectInConvinetWay()
    {
        $this->mock(ExampleService::class, function ($mock) {
            $mock->shouldReceive('giveMeNameBaby')->andReturn('martin')->once();
        });

        $response = $this->json('POST', '/testService');

        $response
            ->assertExactJson(
                ['name' => 'martin']
            );
    }

//    /**
//     * NO 3. Mocking object part.3
//     *
//     */
//    public function testSpyObject()
//    {
//        $this->spy(ExampleService::class, function ($mock) {
//            $mock->shouldReceive('giveMeNameBaby')->andReturn('martin')->once();
//        });
//
//        $response = $this->json('POST', '/testService');
//
//        $response
//            ->assertExactJson(
//                ['name' => 'martin']
//            );
//    }
}
