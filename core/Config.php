<?php

namespace Core;

/**
 * 
 */
class Config{

	private static $_instance;

	public static function getInstance($file){
		if (self::$_instance === null) {
			self::$_instance = new Config($file);
		}
		return self::$_instance;
	}


	public $param = array();


	function __construct($file){

		if ($_ENV === array()) {
			
			$param = require $file;
			
			$this->param = $param;

		}else{

			$this->param = $_ENV;

		}
	}
}