<?php

namespace app\Entity;

use core\Entity\MainEntity;

/**
 * 
 */
class AventuresEntity extends MainEntity{
	

	public function getUrl(){
		return 'index.php?p=av&avID='.$this->id;
	}


}