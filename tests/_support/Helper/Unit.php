<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Unit extends \Codeception\Module
{
    private $originalObject;
    private $class;

    public function __construct($originalObject) {
        $this->originalObject = $originalObject;
        $this->class = new \ReflectionClass($originalObject);
    }

    public function __get($name) {
        $property = $this->class->getProperty($name);
        $property->setAccessible(true);
        return $property->getValue($this->originalObject);
    }

    public function __set($name, $value) {
        $property = $this->class->getProperty($name);            
        $property->setAccessible(true);
        $property->setValue($this->originalObject, $value);
    }

    public function __call($name, $args) {
        $method = $this->class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($this->originalObject, $args);
    }

}
