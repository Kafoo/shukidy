<?php
use app\Manager;
use core\Autoloader;
use app\Router\Router;
use core\DBAuth;

//Controllers
use App\Controller\HomeController;
use App\Controller\AvController;
use App\Controller\ProfilController;
use App\Controller\HelpController;
use App\Controller\AjaxController;
use App\Controller\AuthController;

//Different ROOT if local or not

if (substr(__DIR__, 0, 2) == 'D:') {define('ROOT', '');}
else{define('ROOT', __DIR__);}

//AUTOLOADER
require ROOT . '/app/Manager.php';
Manager::load();

//AUTH
Manager::checkAuth();


//ROUTING
if (isset($_GET['url'])) {

	$router = new Router($_GET['url']);

	//HOME
	$router->get('/', function(){
		$controller = new HomeController;
		$controller->index();
	});

	//INDEX AVENTURES
	$router->get('/aventures', function(){
		$controller = new AvController;
		$controller->index();
	});

	//SHOW AVENTURE
	$router->get('/aventures/:id', function($id){
		$controller = new AvController;
		$controller->show($id);
	});

	//PROFIL
	$router->get('/profil', function(){
		$controller = new ProfilController;
		$controller->show(133);
	});

	//AUTH
	$router->post('/auth/:action', function($action){
		$DBAuth = new DBAuth;
		$DBAuth->$action;
	});

	//EXEMPLE DE POST
	$router->post('/ajax/:action', function($action){
		$controller = new AjaxController;
		$controller->$action();
	});
	
	$router->run();

}