<?php

namespace app\Controller;
use app\Controller\AppController;
use app\Entity\CharactersEntity;
use app\Manager;

/**
 * 
 */
class CharactersController extends AppController{

	public function __construct(){
		parent::__construct();
		$this->loadModel('users');
		$this->loadModel('univers');
		$this->loadModel('carac');
		$this->loadModel('characters');
	}


	public function create(){

		$char = new CharactersEntity;

		foreach ($_POST['data'] as $key => $value) {
			$char->$key = $value;
		}

		$this->characters->add($char);

	}

	public function showCrea($userID)
	{

		$user = $this->users->find($userID);

		if ($user) {		

			$univers = $this->univers->find(2);
			$univers->caracs = $this->carac->findByUniv($univers->id);
			$this->render('crea.character.characterCrea', $univers);
		}else{
			$this->notFound('User not found');
		}
	}
}