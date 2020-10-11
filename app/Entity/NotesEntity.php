<?php

namespace app\Entity;

use core\Entity\MainEntity;

/**
 * 
 */
class NotesEntity extends MainEntity{

	public function __construct(){

		$this->content = htmlspecialchars_decode($this->content);
	}

}