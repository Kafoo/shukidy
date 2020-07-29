<?php

namespace Core;

class Autoloader{

	static function register(){
		spl_autoload_register(array(__CLASS__, 'autoload' ));

	}

	static function autoload($class){

		$class = str_replace('\\', '/', $class);

		/*require ROOT.'/'.$class.'.php';*/

		require ROOT.'/App/Router/Faux.php';
	}

}

?>