<?php


namespace App\Example;


/**
 * Class ExampleServiceWithConstuctor
 *
 * It's example service that is used to learn
 * about service mockery in Laravel
 *
 * @package App\Example
 */
class ExampleServiceWithConstuctor
{
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function giveMeNameBaby()
    {
        return 'aston';
    }

    public function readTemp()
    {
        return rand(1, 3);

    }
}
