<?php
include 'Route.php';
include 'Controller/LogInOutController.php';
class Router {

    private $privateRouteArray = array();
    private $publicRouteArray = array();

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
        $this->privateRouteArray[] = $this->logOutRoute;
    }

    public function addPublicRoute($uri, $object, $objectMethod){
        $route = new Route();
        $route->setUri($uri);
        $route->setObject($object);
        $route->setObjectMethod($objectMethod);
        $this->publicRouteArray[] = $route;
    }

    public function addPrivateRoute($uri, $object, $objectMethod){
        $route = new Route();
        $route->setUri($uri);
        $route->setObject($object);
        $route->setObjectMethod($objectMethod);
        $this->privateRouteArray[] = $route;
    }

    public function routeRequest($userLoggedIn){

        if($userLoggedIn === true){
            $routeArray = array_merge($this->privateRouteArray, $this->publicRouteArray);
        }else{
            $routeArray = $this->publicRouteArray;
        }

        $uri = isset($_REQUEST['requestedURI']) ? $_REQUEST['requestedURI'] : "/";
        $routeMatched = false;
        foreach($routeArray as $key => $route){
            if(preg_match("#^" .$route->getUri() . "$#",$uri ,$params )){
                $route->executeRouteFunctuion($params);
                $routeMatched = true;
                break;
            }
        }

        if($routeMatched === false){
            if($userLoggedIn === false){
                $this->userNotLoggedIn();
            }else {
                // echo error pages
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