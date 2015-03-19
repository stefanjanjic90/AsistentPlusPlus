<?php
include 'Route.php';
include 'Controller/LogInOutController.php';
class Router {

    private $routeArray = array();

    private $logInRoute;
    private $notLoggedInRoute;
    private $logOutRoute;

    public function __construct(){
        $logInOutController = new \AsistentPlusPlus\Controller\LogInOutController();

        $this->logInRoute = new Route();
        $this->logInRoute->setUri("login");
        $this->logInRoute->setObject($logInOutController);
        $this->logInRoute->setObjectMethod("logIn");

        $this->notLoggedInRoute = new Route();
        $this->notLoggedInRoute->setUri("web/index.html");
        $this->notLoggedInRoute->setObject($logInOutController);
        $this->notLoggedInRoute->setObjectMethod("notLoggedIn");

        $this->logOutRoute = new Route();
        $this->logOutRoute->setUri("logout");
        $this->logOutRoute->setObject($logInOutController);
        $this->logOutRoute->setObjectMethod("logOut");
        $this->routeArray[] = $this->logOutRoute;
    }

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
            if(preg_match("#^" .$route->getUri() . "$#",$uri ,$params )){
                $route->executeRouteFunctuion($params);
                break;
            }else{
                // echo error page
            }
        }
    }

    public function userNotLoggedIn(){
        $this->notLoggedInRoute->executeRouteFunctuion();
    }

    public function logInUser(){
        $uri = isset($_REQUEST['requestedURI']) ? $_REQUEST['requestedURI'] : "/";
        if(preg_match("#^" .$this->logInRoute->getUri() . "$#",$uri)){
            $this->logInRoute->executeRouteFunctuion();
        }else{
            $this->notLoggedInRoute->executeRouteFunctuion();
        }
    }
}