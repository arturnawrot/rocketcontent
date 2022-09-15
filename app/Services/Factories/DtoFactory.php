<?php

namespace App\Services\Factories;

use App\Services\Contracts\DtoFactoryInterface;
use App\Services\Contracts\AbstractEntityService;
use App\Exceptions\FactoryException;
use Faker\Generator;

abstract class DtoFactory implements DtoFactoryInterface {

    protected $serviceDestination;

    protected $faker;

    // Service methods usually require some parameters, so this property will store them to later pass them to the serivce.
    protected $parameters;

    protected $dtoObject;

    // All required properties that will be later inserted to DataTransferObject.
    protected $properties;

    protected $result;

    public function __construct() 
    {
        $this->faker = app(Generator::class);

        if(!method_exists($this, 'define')) {
            $clsName = get_class($this);

            throw new FactoryExpection("{$clsName} does not implement define() which is a required method");
        }

        $this->setProperties();
    }

    public function create()
    {
        $this->result = $this->getServiceClass()->{$this->serviceDestination['method']}($this->getDto(), ...$this->getParameters());
        
        return $this->result;
    }

    private function getService() 
    {
        if($this->getServiceClass() instanceof AbstractEntityService) {
            return $instance;
        }

        throw new FactoryException("{$this->serviceClass} does not implement AbstractEntityService");
    }

    private function getServiceClass()
    {
        return app($this->serviceDestination['class']);
    }

    public function addParameters(...$newParameters)
    {
        foreach($newParameters as $newParameterKey => $newParameterValue) {
            $this->parameters[$newParameterKey] = $newParameterValue;
        }
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
        $this->properties = array_replace_recursive($this->getProperties(), $options);
    }

    private function getDto()
    {
        return $this->define();
    }

    protected function generateRandomParameters()
    {
        // Not implemented
        return array();
    }

    public function getProperty(string $propertyName) : mixed 
    {
        return $this->getProperties()["$propertyName"];
    }

    protected function getProperties()
    {
        return $this->properties;
    }

    abstract public function destroy();

    abstract protected function setProperties();

    abstract protected function define();
}