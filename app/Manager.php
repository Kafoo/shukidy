<?php
namespace app;

use core\Config;
use core\Autoloader;
use core\Database;
use core\Controller;
/**
 * General Controller de l'application
 * Recupère la config, la db, les tables, renvoie les erreurs...
 */

class Manager{
	
	private static $_instance;

	private $db_instance;

	private $cssPath = '/public/css';

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
		return '<link rel="stylesheet" type="text/css" href="'.$this->cssPath.'/style.css">';
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

}

?>