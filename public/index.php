<?php

ini_set('display_errors', 1);
ini_set('display_startup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
$dotenv->load();

use Aura\Router\RouterContainer;
use Illuminate\Database\Capsule\Manager as Capsule;

$routerContainer = new RouterContainer();

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => getenv('DB_DRIVER'),
    'host' => getenv('DB_HOST'),
    'database' => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$map = $routerContainer->getMap();

//home en realidad no lo es pero se accede asi nomas
$map->get('index', '/cursoPHP/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
]);

//pagina de agregar Jobs
$map->get('addJob', '/cursoPHP/job/add/', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'AddJobView'
]);

//esto es para poder efectivamente agregar Jobs
$map->post('postJob', '/cursoPHP/job/add/', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'AddJobAction'
]);

//pagina agregar Users
$map->get('addUserView', '/cursoPHP/user/add/', [
    'controller' => 'App\Controllers\UserController',
    'action' => 'AddUserView'
]);

//accion para agregar Users
$map->post('postUser', '/cursoPHP/user/add/', [
    'controller' => 'App\Controllers\UserController',
    'action' => 'AddUserAction'
]);

//ventana de login
$map->get('loginView', '/cursoPHP/login/', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'LoginView'
]);

//metodo para hacer login
$map->post('auth', '/cursoPHP/auth/', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'LoginUser'
]);

//el menu principal
$map->get('menuPrincipal', '/cursoPHP/admin/', [
    'controller' => 'App\Controllers\AdminController',
    'action' => 'AdminView',
    'auth' => TRUE
]);

//para efectuar el logout
$map->get('logout', '/cursoPHP/logout/', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'LogOut'
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
    
//    $needsAuth = $route->handler['auth'] ?? FALSE;
//    $sessionName = $_SESSION['userName'] ?? NULL;
//    if ($needsAuth && !$sessionName) {
//        echo 'protected route';
//        die;
//    } 
    $actionName = $route->handler['action'];
    $controller = new $route->handler['controller'];
    $response = $controller->$actionName($request);

    //esto es necesario para el redirect
    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            header(sprintf('%s: %s', $name, $value), FALSE);
        }
    }

    http_response_code($response->getStatusCode());
    //aca termina lo del redirect

    echo $response->getBody();
}
