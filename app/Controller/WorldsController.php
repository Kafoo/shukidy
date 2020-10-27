<?php

namespace app\Controller;
use app\Controller\AppController;
use app\Manager;

/**
 * 
 */
class WorldsController extends AppController{

	protected $mainName = 'worlds';

	public function __construct(){
		parent::__construct();
		$this->loadModel('natures');
		$this->loadModel('powers');
		$this->loadModel('worlds');
		$this->loadModel('carac');
		$this->loadModel('characters');
	}


	public function deletePower(){

		$powerID = $_POST['powerID'];
		$msg = '';
		$success = 0;

		if (count($this->powers->charHasPower($powerID)) == 0){
			$this->powers->remove($powerID);
			$success = 1;
		}else{
			$msg = 'Un personnage de cet worlds a déjà ce pouvoir ! Tu ne peux pas le supprimer, désolé.';
		}

		$response = [
			'msg' => $msg,
			'success' => $success
		];
		echo json_encode($response);

		$this->log($_SESSION['username'].' a supprimé un pouvoir');


	}

	public function deleteNature(){

		$natureID = $_POST['natureID'];
		$msg = '';
		$success = 0;

		if (count($this->natures->charHasNature($natureID)) == 0){
			$this->natures->remove($natureID);
			$success = 1;
		}else{
			$msg = 'Un personnage de cet worlds a déjà cette nature ! Tu ne peux pas la supprimer, désolé.';
		}

		$response = [
			'msg' => $msg,
			'success' => $success
		];

		echo json_encode($response);

		$this->log($_SESSION['username'].' a supprimé une nature');

	}

	public function createPower(){

		$msg = '';
		$success = 0;
		$worldID = $_POST['worldID'];
		$natureID = $_POST['natureID'];
		$power = json_decode($_POST['power']);

		if (count($this->powers->findByNameAndNature($power->name, $natureID)) == 0) {

			$this->powers->add($worldID, $natureID, $power);
			$success = 1;
		}else{
			$msg = 'Ce nom de pouvoir est déjà pris dans cet univers';
		}


		$response = [
			'msg' => $msg,
			'success' => $success
		];

		echo json_encode($response);

		$this->log($_SESSION['username'].' a créé un pouvoir dans l\'univers '. $worldID);

	}

	public function createNature(){

		$msg = '';
		$success = 0;
		$worldID = $_POST['worldID'];
		$nature = json_decode($_POST['nature']);

		if (count($this->natures->findByNameAndUniv($nature->name, $worldID)) == 0) {

			$this->natures->add($worldID, $nature);
			$success = 1;
		}else{
			$msg = 'Ce nom de nature est déjà pris dans cet univers';
		}

		$response = [
			'msg' => $msg,
			'success' => $success
		];

		echo json_encode($response);

		$this->log($_SESSION['username'].' a créé une nature dans l\'univers '. $worldID);

	}

	public function editCaracs(){

		$msg = '';
		$success = 0;
		$worldID = $_POST['worldID'];
		$caracs = $_POST['caracs'];

		if (count($this->characters->findByUniv($worldID)) == 0) {
			foreach ($caracs as $carac) {
				$carac = json_decode($carac);
				$this->carac->update($carac);
			}
			$success = 1;

			$this->log($_SESSION['username'].' a supprimé un pouvoir');

		}else{
			$msg = 'Au moins une personne a déjà créé un personnage dans ton worlds. Tu ne peux donc pas modifier le nombre de caractéristiques.';
		}



		$response = [
			'msg' => $msg,
			'success' => $success
		];

		echo json_encode($response);

		$this->log($_SESSION['username'].' a édité les caractéristiques de l\'univers '. $worldID);

	}

	public function editAttribute(){

		$what = $_POST['what'];
		$attribute = json_decode($_POST['attribute']);

		if ($what === 'race' || $what === 'classe') {
			$this->natures->edit($attribute);
		}elseif ($what === 'disc' || $what === 'capa') {
			$this->powers->edit($attribute);
		}

		$this->log($_SESSION['username'].' a édité un attribut');

	}

	public function edit(){

		$worldID = $_POST['worldID'];
		$what = $_POST['what'];
		$value = $_POST['value'];

		$this->worlds->edit($what, $worldID, $value);

		$this->log($_SESSION['username'].' a édité la description ou la règle de l\'univers '. $worldID);


	}

	private function getNatures($type, $worldID)
	{
		$data = $this->natures->findByUniv($worldID, $type);
		$data = json_encode($data);
		return $data;
	}

	private function getPowers($natureID)
	{
		$data = $this->powers->findByNature($natureID);
		$data = json_encode($data);
		return $data;
	}

	public function getInfos(){
		$worldID = $_POST['worldID'];
		$what = $_POST['what'];
		$natureID = $_POST['natureID'];

		if ($what === 'race' || $what === "classe") {
			echo $this->getNatures($what, $worldID);
		}

		if ($what === 'capa' || $what === "disc") {
			echo $this->getPowers($natureID);
		}

	}


	public function showCrea($worldID)
	{

		if (Manager::getInstance()->loggedIn()) {

			$world = $this->worlds->find($worldID);
			$world->caracs = $this->carac->findByUniv($world->id);
			$this->render('crea.worlds.worldsCrea', $world);

		}else{
			$this->mustLogIn();
		}
	}


	public function index()
	{
		if (Manager::getInstance()->loggedIn()) {
			$worlds = $this->worlds->getAll();

			$this->render($this->mainName, $worlds);
		}else{
			$this->mustLogIn();
		}
	}

}