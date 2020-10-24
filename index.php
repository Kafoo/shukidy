<?php
use app\Manager;
use app\Router\Router;
use core\DBAuth;

//Controllers
use App\Controller\HomeController;
use App\Controller\AvController;
use App\Controller\ProfilController;
use App\Controller\AjaxController;
use App\Controller\CharactersController;
use App\Controller\HelpController;
use App\Controller\UniversController;

//Different ROOT if local or not

if (substr(__DIR__, 0, 2) == 'D:') {
	define('ROOT', '');
	$isLocal = True;
}else{
	define('ROOT', __DIR__);
	$isLocal = False;
}

//AUTOLOADER
require ROOT . '/app/Manager.php';
Manager::load($isLocal);

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

	//HELP
	$router->get('/help', function(){
		$controller = new HelpController;
		$controller->index();
	});

	//UNIVERS
	$router->get('/univers', function(){
		$controller = new UniversController;
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
		$controller->show();
	});

	//CHARACTER SHEET
	$router->get('/sheet/:id', function($charID){
		$controller = new CharactersController;
		$controller->showSheet($charID);
	});

	//CHARACTER CREATION
	$router->get('/crea/char', function(){
		$controller = new CharactersController;
		$controller->showCrea();
	});

	//AUTH
	$router->post('/auth/:action', function($action){
		$DBAuth = new DBAuth;
		$DBAuth->$action;
	});

	//AJAX
	$router->post('/ajax/:controller/:action', function($controller, $action){
		$controller = str_replace('.', '\\', $controller);
		$controller = 'app\Controller\\'.$controller;
		$controller = new $controller;
		$controller->$action();
	});

	$router->run();

}