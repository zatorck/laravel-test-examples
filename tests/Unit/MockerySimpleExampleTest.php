<?php

namespace Tests\Unit;

use App\Example\Temperature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

/**
 * Class MockerySimpleExampleTest
 *
 * @package Tests\Unit
 *
 * @url http://docs.mockery.io/en/latest/getting_started/simple_example.html
 */
class MockerySimpleExampleTest extends TestCase
{
    /**
     * Simple example test of mockery
     *
     * @return void
     */
    public function testGetsAverageTemperatureFromThreeServiceReadings()
    {
        $service = Mockery::mock('service');
        $service->shouldReceive('readTemp') // its assert
        ->times(3) // its assert
        ->andReturn(10, 12, 14);// its arrange

        $temperature = new Temperature($service);

        $this->assertEquals(12, $temperature->average());
    }
}
