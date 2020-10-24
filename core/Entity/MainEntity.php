<?php

namespace core\Entity;
use app\Manager;
/**
 * 
 */
class MainEntity
{
	
	public function __get($get){
		$method = 'get'.ucfirst($get);
		return $this->$method();
	}

}