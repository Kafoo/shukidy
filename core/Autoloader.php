<?php

namespace core;

class Autoloader{

	static function register(){
		spl_autoload_register(array(__CLASS__, 'autoload' ));

	}

	static function autoload($class){
		$class = lcfirst(str_replace('\\', '/', $class));
		require ROOT.'/'.$class.'.php';
	}

}

?>