<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Class ConsoleTest
 *
 * @url https://laravel.com/docs/5.8/console-tests
 *
 * @package Tests\Feature
 */
class ConsoleTest extends TestCase
{

    /**
     * NO 1. Expecting Input / Output
     */
    public function testExample()
    {

        $this->artisan('question')
            ->expectsQuestion('What is your name?', 'Taylor Otwell')
            ->expectsQuestion('Which language do you program in?',
                'PHP') // This is a bit strange, because artisan is not validating choice same as in CLI
            ->expectsOutput('Your name is Taylor Otwell and you program in PHP.')
            ->assertExitCode(0);
    }
}
