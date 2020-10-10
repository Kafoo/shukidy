<?php

namespace app\Controller;
use app\Controller\AppController;
use app\Entity\EntriesEntity;

/**
 * 
 */
class AlloGMController extends AppController
{

	public function __construct(){
		parent::__construct();
		$this->loadModel('alloGM');
	}

	public function add(){

		$fromID = $_POST['fromID'];
		$toID = $_POST['toID'];
		$avID = $_POST['avID'];
		$content = $_POST['content'];

		$this->allogm->add($avID, $fromID, $toID, $content);

	}

	public function show(){

		$userID = $_POST['userID'];
		$gmID = $_POST['gmID'];

		$res = $this->alloGM->getAllByUsers($userID, $gmID);

		echo json_encode($res);

	}
	
}
