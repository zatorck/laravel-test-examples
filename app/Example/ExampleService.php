<?php


namespace App\Example;


/**
 * Class ExampleService
 *
 * It's example service that is used to learn
 * about service mockery in Laravel
 *
 * @package App\Example
 */
class ExampleService
{
    /**
     * @return string
     */
    public function giveMeNameBaby(): string
    {
        return 'aston';
    }

    public function readTemp()
    {
        return rand(1, 3);

    }
}
