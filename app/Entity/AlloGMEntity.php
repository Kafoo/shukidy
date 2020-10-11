<?php

namespace app\Entity;

use core\Entity\MainEntity;

/**
 * 
 */
class AlloGMEntity extends MainEntity{

	public function __construct(){

		$this->content = htmlspecialchars_decode(nl2br($this->content), ENT_QUOTES);
		
		$this->class = $this->getClass();
		$this->placement = $this->getPlacement();

	}

	public function getClass(){

		if ($this->fromID === $_SESSION['auth']) {
			return 'msg-user';
		}else{
			return 'msg-other';
		}

	}

	public function getPlacement(){

		if ($this->fromID == $_SESSION['auth']) {
			return 'left';
		}else{
			return 'right';
		}

	}

}