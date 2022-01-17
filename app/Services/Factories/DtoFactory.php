<?php

namespace App\Services\Factories;

use App\Services\Contracts\DtoFactoryInterface;
use App\Services\Contracts\AbstractEntityService;
use App\Exceptions\FactoryException;
use Faker\Generator;

abstract class DtoFactory implements DtoFactoryInterface {

    protected $faker;

    protected $parameters;

    protected $dtoObject;

    public function __construct(Generator $faker) 
    {
        $this->faker = $faker;

        if(!method_exists($this, 'define')) {
            $clsName = get_class($this);

            throw new FactoryExpection("{$clsName} does not implement define() which is a required method");
        }

        $this->dtoObject = $this->define();
    }

    public function create()
    {
        return $this->getService()->create($this->getDto(), ...$this->getParameters());
    }

    private function getService() 
    {
        $instance = app($this->serviceClass);

        if($instance instanceof AbstractEntityService) {
            return $instance;
        }

        throw new FactoryException("{$this->serviceClass} does not implement AbstractEntityService");
    }

    public function setParameters(...$parameters)
    {
        $this->parameters = $parameters;
    }

    private function getParameters()
    {
        if(!isset($this->parameters)) {
            return $this->generateRandomParameters();
        }

        return $this->parameters;
    }

    public function override(array $options)
    {
        $dtoObject = $this->getDto();

        $reflect = new \ReflectionClass($dtoObject);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach($options as $property => $optionValue) {
            foreach($props as $prop) {
                if($prop->name === $property) {
                    $dtoObject->{$property} = $optionValue;
                }
            }
        }

        $this->getDto = $dtoObject;
    }

    private function getDto()
    {
        return $this->dtoObject;
    }

    abstract protected function define();

    abstract protected function generateRandomParameters();
}