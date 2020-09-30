<?php
namespace app;

use core\Config;
use core\Autoloader;
use core\Database;
use core\Controller;

/**
 * Recupère la config, la db, les tables...
 */

class Manager{
	
	private static $_instance;

	private $db_instance;

	private $cssPath = '/public/css';
	private $jsPath = '/app/js';

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


	public function login($user){
        setcookie('auth', $user->id.'---'.sha1($user->username), time()+3600*24*365, "/", null, false, true);
		$_SESSION['connected'] = true;
		$_SESSION['username'] = $user->username;
		$_SESSION['grade'] = $user->grade;
		$_SESSION['auth'] = $user->id;
		$_SESSION['characters'] = serialize($this->getTable('characters')->findByUser($user->id));
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

	public function getScript(){
		if (isset($this->script)) {
			return $this->script;
		} else{
			return False;
		}
	}

	public function setScript($script){
		$this->script = '<script src="'.$this->jsPath.'/'.$script.'.js"></script>';
	}

	public function isMobile(){
		require ROOT.'/vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
		$mobiledetect = new \Mobile_Detect;
		return $mobiledetect->isMobile();
	}
	
}
?>