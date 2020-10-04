<?php

namespace app\Controller;
use app\Controller\AppController;
use app\Manager;

/**
 * 
 */
class AjaxController extends AppController{

	public function __construct(){
		parent::__construct();
		$this->loadModel('users');
	}

	public function trylogin(){

		$username = $_POST['username'];
		$password = sha1($_POST['password']);
		$login = Manager::getInstance()->login($username, $password);

		echo $login;
	}

	public function logout(){

		$_SESSION = array();
		setcookie('auth', "", time()-3600, '/');
		session_destroy();
	}


}

?>