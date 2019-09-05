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

    private $exampleTwoService;

    public function __construct(ExampleTwoService $exampleTwoService)
    {
        $exampleTwoService = $exampleTwoService;
    }

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

    public function name()
    {
        return $this->exampleTwoService->giveMeNameBaby();
    }
}
