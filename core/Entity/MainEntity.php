<?php

namespace core\Entity;

/**
 * 
 */
class MainEntity
{
	
	public function __get($get){
		$method = 'get'.ucfirst($get);
		$this->$get = $this->$method();
		return $this->$get;
	}

}