<?php
use App\Manager;
use App\Router\Router;
use Core\Autoloader;


define('ROOT', __DIR__);
require ROOT . '/app/Manager.php';
/*require ROOT . '/core/Autoloader.php';*/

/*Autoloader::autoload('App/Router/Router');*/
require ROOT.'/App/Router/Router.php';
Router::coucou();

/*Manager::load();

Router::coucou();*/

/*if (isset($_GET['url'])) {

	$router = new Router($_GET['url']);

	$router->get('/', function(){ echo "Accueil"; });

	$router->get('/aventures', function(){ echo "Index de toutes les aventures"; });

	$router->get('/aventures/:id', function($id){ echo "Ca c'est l'aventure ".$id; });

	$router->post('/aventure/:id', function($id){ echo "Ca je sais pas encore trop à quoi ça sert mais l'id c'est ".$id; });

	$router->run();

}*/



?>
fin