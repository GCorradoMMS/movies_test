<?php 
define('__ROOT__', dirname(__FILE__)); 
require_once(__ROOT__.'/controller/MoviesController.php');
require_once(__ROOT__.'/utils/Utils.php');

$movies = new MoviesController;
$utils = new Utils;

$utils->appHeader();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ($uri[1] !== 'movies') {
    $utils->notFound();
}

$method = $_SERVER['REQUEST_METHOD']; 

// GET & POST
switch ($uri[2]) {
    case 'all':
        $result = $movies->all();
        print_r(json_encode($result));
        break;
    case 'get':
        $id = $_GET['id'];
        $result = $movies->get($id);
        print_r(json_encode($result));
        break;
    case 'create':
        $movie = $_POST['info'];
        $movies->create($movie);
        break;
    case 'update' :
        $update = $_POST['info'];
        $id = $_POST['id'];
        $movies->update($update, $id);
        break;
    case 'delete' :
        $id = $_POST['id'];
        $movies->delete($id);
        break;
    // case 'setup-migration' : Setup a migration in a fresh installation
    //      $movies->migrate();
    //      break;
    default:
        $utils->notFound(); 
        break;
}