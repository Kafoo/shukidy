<?php

namespace Core;

class Autoloader{

	static function register(){
		echo "register done";
		spl_autoload_register(array(__CLASS__, 'autoload' ));
	}

	static function autoload($class){
		$class = str_replace('\\', '/', $class);
		require __DIR__.'/../'.$class.'.php';
	}

}

?>