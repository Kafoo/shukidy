<?php

namespace app\Controller;
use app\Controller\AppController;
use core\Auth\DBAuth;
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
		$user = $this->users->findByName($username);

		if ($user) {
			if ($user->password === $password) {
				Manager::getInstance()->login($user);
				echo 'loggedin';

			}else{
				echo "Mot de passe invalide";
			}
		}else{
			echo "Pseudo invalide";
		}
	}

	public function logout(){
		$_SESSION = array();
		setcookie('auth', "", time()-3600, '/');
		session_destroy();

	}


}

?>