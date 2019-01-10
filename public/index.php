<?php

ini_set('display_errors', 1);
ini_set('display_startup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use Aura\Router\RouterContainer;
use Illuminate\Database\Capsule\Manager as Capsule;
$routerContainer = new RouterContainer();

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'cursophp',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$map = $routerContainer->getMap();

//home
$map->get('index', '/cursoPHP/', [
    'controller'=>'App\Controllers\IndexController',
    'action'=>'indexAction'
 ]);

//pagina de agregar jobs
$map->get('addJob', '/cursoPHP/job/add/',[
    'controller'=>'App\Controllers\JobsController',
    'action'=>'AddJobAction'
 ]);

//esto es para poder efectivamente agregar jobs
$map->post('postJob', '/cursoPHP/job/add/',[
    'controller'=>'App\Controllers\JobsController',
    'action'=>'AddJobAction'
 ]);

$matcher = $routerContainer->getMatcher();

function printJob($job) {   
    
    echo '<li>';
    echo '<h5> titulo: ' . $job->title . '</h5>';
    echo '<p> descripcion: ' . $job->description . '</p>';
    echo '<p> meses: ' . $job->months . '</p>';
    echo '<strong>Achievements:</strong>';
    echo '</li>';
  }

$route = $matcher->match($request);
if (!$route) {
    echo 'no route ';
    var_dump($route);
} else {
    $actionName=$route->handler['action'];
    $controller=new $route->handler['controller'];

    $response= $controller->$actionName($request);
    echo $response->getBody();

}
