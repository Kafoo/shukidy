<?php


use core\Database;
use app\Manager;
use core\Auth\DBAuth;

define('ROOT', dirname(__DIR__));

require ROOT . '/app/Manager.php';
Manager::load();
$manager = Manager::getInstance();


if (isset($_GET['p']) AND $_GET['p'] !== '') {
	$p = $_GET['p'];
}else{
	$p = 'home';
}



// AUTH

$auth = new DBAuth($manager->getDb());
var_dump($auth->login('Kafoo', 'sSund4Hu!'));
var_dump($auth->logged());
if (!$auth->logged()) {
	$manager->forbidden();
}


ob_start();


if ($p === 'home') {

	require ROOT . '/pages/admin/home.php';

}elseif ($p === 'av_list') {

	require ROOT . '/pages/admin/aventures/av_list.php';

}elseif ($p === 'av') {
	
	require ROOT . '/pages/admin/aventures/av.php';

}elseif ($p === 'av.delete') {
	
	require ROOT . '/pages/admin/aventures/av_delete.php';

}else{
	
	require '../pages/404.php';

}

$content = ob_get_clean();

require '../pages/templates/default.php';


?>