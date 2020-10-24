<?php

namespace app\Entity;

use core\Entity\MainEntity;
use app\Controller\ImgController;
use app\Manager;
/**
 * 
 */
class CharactersEntity extends MainEntity{


	public function setName($name){

		$this->name = $name;

	}

	public function getAvatar(){

		$img = new ImgController;

		if ($this->name == 'GM') {
			return $img->avatar('GM');
		}else{
			return $img->avatar($this->id);
		}

	}


	private function getNature($type){

		$naturesTable = Manager::getInstance()->getTable('natures');
		$natures = $naturesTable->findByChar($this->id);

		foreach ($natures as $nature) {
			if ($nature->type === $type) {
				return $nature;
			}
		}
	}

	public function getClasse(){

		return $this->getNature('classe');
	}

	public function getRace(){

		return $this->getNature('race');
	}


public function getPowers($type){

	$powersTable = Manager::getInstance()->getTable('powers');
	$powers = $powersTable->findByChar($this->id);

	$typedPowers = [];
	foreach ($powers as $power) {
		if ($power->type === $type) {
			array_push($typedPowers, $power);
		}
	}
	return $typedPowers;

}

	public function getDisciplines(){

		return $this->getPowers('disc');
	}

	public function getCapacités(){

		return $this->getPowers('capa');
	}

	public function getNextLvlPourcent(){

		$xp = $this->xp;
		$minxp = $this->minxp;
		$nextLVL = $this->nextlvl; 
		return round(($xp-$minxp)*100/($nextLVL-$minxp)); 

	}

}