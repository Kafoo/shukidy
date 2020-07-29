<?php

namespace App\Entity;

use Core\Entity\MainEntity;

/**
 * 
 */
class AventuresEntity extends MainEntity{
	

	public function getUrl(){
		return 'index.php?p=av&avID='.$this->id;
	}


}