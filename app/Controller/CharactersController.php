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

	public function delete(){

		$charID = $_POST['charID'];

		$this->characters->remove($charID);

	}

	public function create(){

		$char = new CharactersEntity;

		foreach ($_POST['data'] as $key => $value) {

			$this->hydrate($char, $key, $value);

		}

		$this->characters->add($char);

		$newChar = $this->characters->findByName($char->name);
		echo $newChar->id;

	}


	public function showCrea()
	{

		if (Manager::getInstance()->loggedIn()) {

			$univers = $this->univers->find(2);
			$univers->caracs = $this->carac->findByUniv($univers->id);
			$this->render('crea.character.characterCrea', $univers);

		}else{
			$this->mustLogIn();
		}
	}

	public function showSheet($charID){

		if (Manager::getInstance()->loggedIn()) {

			$char = $this->characters->find($charID);
			if ($char) {
				if ($char->userID = $_SESSION['auth']) {
					$char->fromUser = true;
				}else{
					$char->fromUser = false;
				}
			}else{
				$this->notFound('Personnage inconnu !');
			}

			$char->caracs = $this->carac->findByChar($char->id);
			$this->render('sheet', $char);


		}else{
			$this->mustLogIn();
		}	

	}

}