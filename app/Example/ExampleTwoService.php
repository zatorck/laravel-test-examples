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
class ExampleTwoService
{
    private $temperature;

    public function __construct(TemperatureInterface $temperature)
    {
        $this->temperature = $temperature;
    }

    /**
     * @return string
     */
    public function giveMeNameBaby()
    {
        return 'ferrari';
    }

    public function getTemp()
    {
        return $this->temperature->average(1);
    }
}
