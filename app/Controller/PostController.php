<?php

namespace app\Controller;
use app\Controller\AppController;
use app\Entity\EntriesEntity;

/**
 * 
 */
class PostController extends AppController
{

	public function __construct(){
		parent::__construct();
		$this->loadModel('entries');
		$this->loadModel('characters');
	}


	public function post(){

		$entry = new EntriesEntity;

		$entry->avID = $_POST['avID'];
		$entry->charID = $_POST['charID'];
		$entry->content = $_POST['content'];

		$userChar = $this->characters->findUserChar($_POST['avID']);
		if ($userChar->name == 'GM') {
			$entry->type = 'rpGM';
		}else{
			$entry->type = 'rpPlayer';
		}


		$entry->dat = 
		sprintf('%02d', getdate()['mday']) . '/' . 
		sprintf('%02d', getdate()['mon']) . '/' . 
		getdate()['year'] . '--' . 
		sprintf('%02d', (getdate()['hours']+2)) . ':' . 
		sprintf('%02d', getdate()['minutes']);
		//WTF VIRE MOI CA

		$last = $this->entries->lastByAv($entry->avID);
		//On défini le postID (incrémentation ou non)
		if ($entry->charID == $last->charID 
		AND ($last->type == 'rpPlayer' OR $last->type == 'drPlayer' OR $last->type == 'rpGM')) {
			$entry->postID = $last->postID;
		} else {
			$entry->postID = $last->postID+1;
		}
		$this->entries->add($entry);

	}


}