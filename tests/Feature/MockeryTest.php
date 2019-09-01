<?php

namespace Tests\Feature;

use App\Example\ExampleTwoService;
use Tests\TestCase;
use Mockery;
use App\Example\ExampleService;

/**
 * Class MockeryTest\
 *
 * Case of using test doubles is to substitute real dependencies in testing object, by the abstract that we can control.
 * We can decide to use them if we don't need or can use real dependencies of object - testing them is not a case.
 * Test doubles do not need to implement real functionalists  of real object, just giving API need be testing class.
 * There is few types of Test doubles:
 *
 * Stub - This type is using when behaviour of testing class depends of returning value from another object.
 *        To test our function we need to be sure what is going to be returned, by the stub. We don't need any external
 *        dependencies in the stubbed class. In this case we can use Stub, where we are sure what is going to be
 *        returned.
 *
 * Spy - Using when testing class do not expect any return value, giving them responsibility for future actions.
 *       This way we are sure that spied class was used with known parameters. It's "observation point" witch helps us
 *       to verify that we use but not test our dependencies themselves.
 *
 * Mock object - We can call it combination of Stub and Spy. We use Mocking object when we need expecting response in
 *               case of giving specific value. We can use Mocking object multiple times with different value.
 *
 * Fake object - sometimes real dependency can be swapped by lighter implantation, giving us need functionality, but
 *               without other side effects. Simplicity of object means that we can depend of its behaviour, without
 *               creating assumptions all the time.
 *
 * Dummy object - Sometime we don't need functionalists of object but only giving instance of itself. We don't need
 *                implementation, only it's presence. In this case we use Dummy object.
 *
 * @url http://docs.mockery.io/en/latest/index.html
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
