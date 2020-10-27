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
		$this->loadModel('worlds');
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

	public function addToAv(){

		$charID = $_POST['charID'];
		$avID = $_POST['avID'];

		$data = $this->characters->addToAv($charID, $avID);

		echo $data;

	}

	public function listByAv(){

		$userID = $_POST['userID'];
		$worldID = $_POST['worldID'];

		$characters = $this->characters->findByUserAndWorld($userID, $worldID);

		echo json_encode($characters);

	}


	public function showCrea($worldID)
	{

		if (Manager::getInstance()->loggedIn()) {

			$world = $this->worlds->find($worldID);
			$world->caracs = $this->carac->findByUniv($worldID);
			$this->render('crea.character.characterCrea', $world);

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