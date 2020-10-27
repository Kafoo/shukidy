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

		$this->alloGM->add($avID, $fromID, $toID, $content);

		if ($toID == '132') {
			$this->mail('Nouveau message sur alloGM', 'Nouveau message de '. $_SESSION['username']);
		}

	}

	public function show(){

		$userID = $_POST['userID'];
		$gmID = $_POST['gmID'];
		$avID = $_POST['avID'];

		$res = $this->alloGM->getByUsersAndAv($userID, $gmID, $avID);

		echo json_encode($res);

	}
	
}
