<?php


namespace App\Example;


class Temperature implements TemperatureInterface
{
    private $service;

    /**
     * Temperature constructor.
     *
     * You cannot use autowire while you dont give full name of class in \Mockery::mock()
     * for this mockery test so in real world it wont work
     *
     * @url http://docs.mockery.io/en/latest/getting_started/simple_example.html
     *
     * @param $service
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * This function if fixed to test
     *
     * @param  int  $start
     *
     * @return float|int
     */
    public function average($start = 0)
    {
        $total = $start;
        for ($i = 0; $i < 3; $i++) {
            $total += $this->service->readTemp();
        }

        return $total / 3;
    }
}
