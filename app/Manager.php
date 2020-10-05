<?php
namespace app;

use core\Config;
use core\Autoloader;
use core\Database;
use app\Controller\AuthController;

/**
 * Recupère la config, la db, les tables...
 */

class Manager{
	
	private static $_instance;

	private $db_instance;

	private $cssPath = '/public/css';
	private $jsPath = '/app/js';
	private $nodePath = '/node_modules';
	private $script = '';

	public function __construct(){

		$config = Config::getInstance(ROOT . '/config/config.php');
		foreach ($config->param as $key => $value) {
			$this->$key = $value;
		}
	}


	/**
	 * Gets the instance.
	 *
	 * @return     <type>  The instance.
	 */
	public static function getInstance(){
		if (is_null(self::$_instance)) {

			self::$_instance = new Manager();

		}
		return self::$_instance;
	} 

	public static function load(){
		session_start();
		require ROOT . '/core/Autoloader.php';
		Autoloader::register();
	}


	public function login($username, $password){

		$authController = new AuthController;

		$user = $authController->users->findByName($username);

		if ($user) {
			if ($user->password === $password) {
				$authController->auth($user);
				return True;

			}else{
				return "Mot de passe invalide";
			}
		}else{
			return "Pseudo invalide";
		}
	}

	public static function checkAuth(){

		$authController = new AuthController;

		if (isset($_COOKIE['auth'])) {

	        $auth = $_COOKIE['auth'];
	        $auth = explode("---", $auth);
	        $userID = $auth[0];
	        $usernameSha = $auth[1];
	        $user = $authController->users->find($userID);

	        if ($user AND sha1($user->username) == $usernameSha) {
	        	$authController->auth($user);
	        }

	        //FAKE USER
	        /*$userID = 132;
	        $user = $authController->users->find($userID);
			$authController->auth($user);*/

		}

	}


	public function loggedIn(){
		if (isset($_SESSION['auth'])) {
			return True;
		}else{
			return False;
		}
	}

	public function getDb(){
		if (is_null($this->db_instance)) {
			$this->db_instance = new Database($this->db_name, $this->db_user, $this->db_pass, $this->db_host);
		}		
		return $this->db_instance;
	}


	public function getTable($table_name){
		$class = '\\app\\Table\\' . ucfirst($table_name) . 'Table';
		return new $class($this->getDb());
	}


	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getDefaultStyle(){
		return '<link rel="stylesheet" type="text/css" href="'.$this->cssPath.'/_shared_/style.css">';
	}

	public function getStyle(){
		if (isset($this->style)) {
			return $this->style;
		} else{
			return False;
		}
	}

	public function setStyle($style){
		$this->style = '<link rel="stylesheet" type="text/css" href="'.$this->cssPath.'/'.$style.'.css">';
	}

	public function getDefaultScript(){
		return '<script type="module" src="'.$this->jsPath.'/index.js"></script>';
	}

	public function getScripts(){
		if (isset($this->script)) {
			return $this->script;
		} else{
			return False;
		}
	}

	public function addScript($src, $script){

		$script = str_replace('.', '/', $script);

		if ($src == 'app') {
			$src = $this->jsPath.'/'.$script.'.js';

		}elseif ($src == 'node'){
			$src = $this->nodePath.'/'.$script.'.js';
		}
		
		$this->script .= '<script type="module" src="'.$src.'"></script>';
	}

	public function isMobile(){
		require ROOT.'/vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
		$mobiledetect = new \Mobile_Detect;
		return $mobiledetect->isMobile();
	}
	
}
?>