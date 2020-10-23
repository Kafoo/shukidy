<?php

namespace app\Controller;
use app\Controller\AppController;
use app\Manager;

/**
 * 
 */
class UniversController extends AppController{

	public function __construct(){
		parent::__construct();
		$this->loadModel('natures');
		$this->loadModel('powers');
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

}