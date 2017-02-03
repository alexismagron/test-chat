<?php

include ('./../vendor/autoload.php');

$url = $_SERVER['REQUEST_URI'];

$routes = array(
    /**
     * "/route" => array(
     *      'controller' => 'Controller',
     *      'method' => 'method'
     * );
     */
    '/login' => array(
        'controller' => 'UserCtrl',
        'method' => 'login'
    ),
    '/chat/{id}' => array(
        'controller' => 'ChatCtrl',
        'method' => 'chat'
    )
    
);
//Appelle la méthode dans le bon controleur et passe les parametre à la méthode
foreach(array_keys($routes) as $path){
    //Remplace les parametres indiqués dans les routes par un pattern permettant de récupérer le paramètre
    $pattern = preg_replace("#\{[a-z0-9]*\}#", "([0-9]+)", $path);
    $regex = "#^" . $pattern . "$#";    
    $matches = array();
    //Si la route match avec l'url
    if(preg_match($regex, $url, $matches)){        
        $controller_name = "Controller\\".$routes[$path]['controller'];
        $method_name = $routes[$path]['method'];
        
        $controller = new $controller_name;
        $parameters = count($matches) > 0 ? array_slice($matches, 1) : array();
        call_user_func_array(array($controller, $method_name), $parameters);
        break;        
    }    
}









