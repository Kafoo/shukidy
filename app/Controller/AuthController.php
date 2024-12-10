<?php

namespace app\Controller;
/**
 * 
 */
class AuthController extends AppController
{
	
	function __construct(){
		$this->loadModel('users');
		$this->loadModel('characters');
	}

	public function auth($user){
        setcookie('auth', $user->id.'---'.sha1($user->username), time()+3600*24*365, "/", null, false, true);
		$_SESSION['connected'] = true;
		$_SESSION['username'] = $user->username;
		$_SESSION['grade'] = $user->grade;
		$_SESSION['auth'] = $user->id;
		$_SESSION['characters'] = serialize($this->characters->findByUser($user->id));

	}

}


?>