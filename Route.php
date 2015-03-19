<?php

class Route {

    private $uri;
    private $object;
    private $objectMethod;


    public function executeRouteFunctuion(){
        $obj = $this->object;
        $method = $this->objectMethod;
        $obj->$method(func_get_args());
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function setObject($object)
    {
        $this->object = $object;
    }

    public function getObjectMethod()
    {
        return $this->objectMethod;
    }

    public function setObjectMethod($objectMethod)
    {
        $this->objectMethod = $objectMethod;
    }
}