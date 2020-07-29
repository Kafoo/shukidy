<?php

namespace Core;

class Autoloader{

	static function register(){
		spl_autoload_register(array(__CLASS__, 'autoload' ));

	}

	static function autoload($class){
		echo'yo';
		$class = str_replace('\\', '/', $class);
		var_dump(ROOT.'/'.$class.'.php');
		require ROOT.'/'.$class.'.php';
	}

}

?>