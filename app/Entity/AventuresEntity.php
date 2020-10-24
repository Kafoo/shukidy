<?php

namespace app\Entity;

use core\Entity\MainEntity;
use app\Manager;
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

	public function getWriterName(){

		foreach ($this->characters as $character) {
			if ($this->writerID === $character->userID) {
				return  $character->name;
			}
		}

		return False;

	}

	public function getUserIsIn(){

		$manager = Manager::getInstance();
		$userChars = $manager->getTable('characters')->findByUser($_SESSION['auth']);
		$avChars = $manager->getTable('characters')->findByAv($this->id);
		foreach ($avChars as $avChar) {
			foreach ($userChars as $userChar) {
				if ($userChar->id === $avChar->id) {
					return True;
				}
			}
		}
		return False;
	}

}