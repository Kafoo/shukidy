<?php
use App\Manager;
use App\Router\Router;


$root = dirname(__DIR__);
if ($root == 'D:\DEV\wamp64\www') {
	$root = dirname(__DIR__)."/shukidy";
}

var_dump($root);

require $root.'/plop.php';

/*if (isset($_GET['url'])) {
define('ROOT', dirname(__DIR__).'/shukidy');
require ROOT . '/app/Manager.php';
Manager::load();


	$router = new Router($_GET['url']);

	$router->get('/', function(){ echo "Accueil"; });

	$router->get('/aventures', function(){ echo "Index de toutes les aventures"; });

	$router->get('/aventures/:id', function($id){ echo "Ca c'est l'aventure ".$id; });

	$router->post('/aventure/:id', function($id){ echo "Ca je sais pas encore trop à quoi ça sert mais l'id c'est ".$id; });

	$router->run();

}*/





?>