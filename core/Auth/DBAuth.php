<?php

namespace core\Auth;

use core\Database;
/**
 * 
 */
class DBAuth{
	

	private $db;

	public function __construct(Database $db){
		$this->db = $db;
	}

	public function getUserID(){

		if ($this->logged()) {
			return $_SESSION['auth'];
		}
		return false;

	}

	public function login($username, $password){
		$user = $this->db->prepare(
			"SELECT *
			FROM users
			WHERE username = ?",
			[$username],
			null, true
		);
		if ($user) {
			if ($user->password === sha1($password)){
                setcookie('auth', $user->id.'---'.sha1($user->username), time()+3600*24*365, null, null, false, true);
				$_SESSION['connected'] = true;
				$_SESSION['username'] = $user->username;
				$_SESSION['grade'] = $user->grade;
				$_SESSION['auth'] = $user->id;
				return true;
			}
		}

		return false;

	}

	public function logged(){
		return isset($_SESSION['auth']);
	}
	
}