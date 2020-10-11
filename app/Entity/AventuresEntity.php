<?php

namespace app\Entity;

use core\Entity\MainEntity;

/**
 * 
 */
class AventuresEntity extends MainEntity{
	

	public function __construct(){
		$this->description = htmlspecialchars_decode($this->description);
	}

	public function getUrl(){
		return '/aventures/'.$this->id;
	}

}