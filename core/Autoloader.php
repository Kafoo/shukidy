<?php

namespace Core;

class Autoloader{

	static function register(){
		spl_autoload_register(array(__CLASS__, 'autoload' ));
		var_dump(__DIR__);

	}

	static function autoload($class){
		echo'yo';
		$class = str_replace('\\', '/', $class);
		var_dump(__DIR__);
		/*require __DIR__.'/../'.$class.'.php';*/
	}

}

?>