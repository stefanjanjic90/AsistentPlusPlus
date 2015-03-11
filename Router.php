<?php
include 'Route.php';
class Router {

    private $routeArray = array();

    public function add($uri, $object, $objectMethod){
        $route = new Route();
        $route->setUri($uri);
        $route->setObject($object);
        $route->setObjectMethod($objectMethod);
        $this->routeArray[] = $route;
    }

    public function routeRequest(){
        $uri = isset($_REQUEST['requestedURI']) ? $_REQUEST['requestedURI'] : "/";

        foreach($this->routeArray as $key => $route){
            if(preg_match("#^" .$route->getUri() . "$#",$uri )){
                $route->executeRouteFunctuion();
            }else{
                // echo error page
            }
        }
    }
}