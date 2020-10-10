<?php

namespace core\Entity;

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