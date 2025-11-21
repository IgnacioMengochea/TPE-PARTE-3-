<?php

class Router {
    private $routeTable = [];
    private $defaultRoute = null;

    public function route($url, $verb) {
        foreach ($this->routeTable as $route) {
            if($route->match($url, $verb)){
                $route->run();
                return;
            }
        }
        echo "404 Page Not Found"; 
    }

    public function addRoute($url, $verb, $controller, $method) {
        $this->routeTable[] = new Route($url, $verb, $controller, $method);
    }
}

class Route {
    private $url;
    private $verb;
    private $controller;
    private $method;
    private $params;

    public function __construct($url, $verb, $controller, $method){
        $this->url = $url;
        $this->verb = $verb;
        $this->controller = $controller;
        $this->method = $method;
        $this->params = [];
    }

    public function match($url, $verb) {
        if($this->verb != $verb){
            return false;
        }
        $partsURL = explode("/", trim($url,'/'));
        $partsRoute = explode("/", trim($this->url,'/'));
        
        if(count($partsURL) != count($partsRoute)){
            return false;
        }
        
        foreach ($partsRoute as $key => $part) {
            if($part[0] != ":"){
                if($part != $partsURL[$key])
                return false;
            } else {
                $this->params[''.substr($part,1)] = $partsURL[$key];
            }
        }
        return true;
    }

    public function run(){
        $controller = $this->controller;  
        $method = $this->method;
        $params = $this->params;
    
        $req = new stdClass();
        $req->params = (object)$params;
        $req->body = json_decode(file_get_contents("php://input"));
        $req->query = (object)$_GET;

        $res = new Response();
        (new $controller())->$method($req, $res);
    }
}

class Response {
    public function json($data, $status = 200) {
        header("Content-Type: application/json");
        http_response_code($status);
        echo json_encode($data);
    }
}