<?php
use app\Manager;
use app\Router\Router;
use core\DBAuth;

//Controllers
use app\Controller\HomeController;
use app\Controller\AvController;
use app\Controller\ProfilController;
use app\Controller\AjaxController;
use app\Controller\CharactersController;
use app\Controller\HelpController;
use app\Controller\WorldsController;
use app\Controller\AppController;

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
	$router->get('/worlds', function(){
		$controller = new WorldsController;
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
	$router->get('/crea/char/:id', function($worldID){
		$controller = new CharactersController;
		$controller->showCrea($worldID);
	});

	//WORLD CREATION
	$router->get('/crea/world/:id', function($worldID){
		$controller = new WorldsController;
		$controller->showCrea($worldID);
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

	//LOG
	$router->get('/log', function(){
		$controller = new AppController;
		$controller->showLog();
	});

	$router->run();

}