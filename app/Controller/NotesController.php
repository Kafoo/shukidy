<?php

namespace app\Controller;
use app\Controller\AppController;
use app\Entity\EntriesEntity;

/**
 * 
 */
class NotesController extends AppController
{

	public function __construct(){
		parent::__construct();
		$this->loadModel('notes');
	}

	public function update(){

		$avID = $_POST['avID'];
		$userID = $_POST['userID'];
		$content = nl2br(htmlspecialchars($_POST['content'], ENT_QUOTES));

		$this->notes->update($avID, $userID, $content);

	}

	public function show(){

		$avID = $_POST['avID'];
		$userID = $_POST['userID'];

		$res = $this->notes->getByUserAndAv($userID, $avID);

		echo json_encode($res);

	}
	
}
