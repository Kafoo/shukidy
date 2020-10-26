<?php

namespace app\Controller;
use app\Controller\AppController;
use app\Manager;

/**
 * 
 */
class UniversController extends AppController{

	protected $mainName = 'univers';

	public function __construct(){
		parent::__construct();
		$this->loadModel('natures');
		$this->loadModel('powers');
		$this->loadModel('univers');
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
			$msg = 'Un personnage de cet univers a déjà ce pouvoir ! Tu ne peux pas le supprimer, désolé.';
		}

		$response = [
			'msg' => $msg,
			'success' => $success
		];
		echo json_encode($response);

	}

	public function deleteNature(){

		$natureID = $_POST['natureID'];
		$msg = '';
		$success = 0;

		if (count($this->natures->charHasNature($natureID)) == 0){
			$this->natures->remove($natureID);
			$success = 1;
		}else{
			$msg = 'Un personnage de cet univers a déjà cette nature ! Tu ne peux pas la supprimer, désolé.';
		}

		$response = [
			'msg' => $msg,
			'success' => $success
		];

		echo json_encode($response);

	}

	public function createPower(){

		$msg = '';
		$success = 0;
		$univID = $_POST['univID'];
		$natureID = $_POST['natureID'];
		$power = json_decode($_POST['power']);

		if (count($this->powers->findByNameAndNature($power->name, $natureID)) == 0) {

			$this->powers->add($univID, $natureID, $power);
			$success = 1;
		}else{
			$msg = 'Ce nom de pouvoir est déjà pris dans cet univers';
		}


		$response = [
			'msg' => $msg,
			'success' => $success
		];

		echo json_encode($response);

	}

	public function createNature(){

		$msg = '';
		$success = 0;
		$univID = $_POST['univID'];
		$nature = json_decode($_POST['nature']);

		if (count($this->natures->findByNameAndUniv($nature->name, $univID)) == 0) {

			$this->natures->add($univID, $nature);
			$success = 1;
		}else{
			$msg = 'Ce nom de nature est déjà pris dans cet univers';
		}

		$response = [
			'msg' => $msg,
			'success' => $success
		];

		echo json_encode($response);

	}

	public function editCaracs(){

		$msg = '';
		$success = 0;
		$univID = $_POST['univID'];
		$caracs = $_POST['caracs'];

		if (count($this->characters->findByUniv($univID)) == 0) {
			foreach ($caracs as $carac) {
				$carac = json_decode($carac);
				$this->carac->update($carac);
			}
			$success = 1;
		}else{
			$msg = 'Au moins une personne a déjà créé un personnage dans ton univers. Tu ne peux donc pas modifier le nombre de caractéristiques.';
		}



		$response = [
			'msg' => $msg,
			'success' => $success
		];

		echo json_encode($response);

	}

	public function editAttribute(){

		$what = $_POST['what'];
		$attribute = json_decode($_POST['attribute']);

		if ($what === 'race' || $what === 'classe') {
			$this->natures->edit($attribute);
		}elseif ($what === 'disc' || $what === 'capa') {
			$this->powers->edit($attribute);
		}

	}

	public function edit(){

		$univID = $_POST['univID'];
		$what = $_POST['what'];
		$value = $_POST['value'];

		$this->univers->edit($what, $univID, $value);
	}

	private function getNatures($type, $univID)
	{
		$data = $this->natures->findByUniv($univID, $type);
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
		$univID = $_POST['univID'];
		$what = $_POST['what'];
		$natureID = $_POST['natureID'];

		if ($what === 'race' || $what === "classe") {
			echo $this->getNatures($what, $univID);
		}

		if ($what === 'capa' || $what === "disc") {
			echo $this->getPowers($natureID);
		}

	}


	public function showCrea()
	{

		if (Manager::getInstance()->loggedIn()) {

			$univers = $this->univers->find(2);
			$univers->caracs = $this->carac->findByUniv($univers->id);
			$this->render('crea.univers.universCrea', $univers);

		}else{
			$this->mustLogIn();
		}
	}


	public function index()
	{
		$this->render($this->mainName, null);
	}


}