<?php

use app\Manager;
use app\Router\Router;
use core\Autoloader;

//Controllers
use App\Controller\AvController;
use App\Controller\HomeController;
use App\Controller\ProfilController;
use App\Controller\HelpController;

//Different ROOT if local or not
if (substr(__DIR__, 0, 2) == 'D:') {define('ROOT', '');}
else{define('ROOT', __DIR__);}

//AUTOLOADER
require ROOT . '/app/Manager.php';
Manager::load();

use core\Database;

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
		$controller->setSession();
		$controller->show($id);
	});

	//INDEX AVENTURES
	$router->get('/profil', function(){
		$controller = new ProfilController;
		$controller->show(133);
	});


	//EXEMPLE DE POST
	$router->post('/aventure/:id', function($id){});
	

	$router->run();



}



?>