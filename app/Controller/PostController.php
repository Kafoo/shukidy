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
		$this->loadModel('carac');
	}

	public function rollTheDice(){

		foreach ($_POST['data'] as $key => $value) {
			$$key = $value;
		}

		$this->entries->rollUpdate($entryID, $result);

	}

	public function dicereply(){

		$entry = new EntriesEntity;

		foreach ($_POST['data'] as $key => $post) {
			$entry->$key = $post;
		}

		$userChar = $this->characters->findByUserAndAv($entry->avID);
		$UserCaracs = $this->carac->findByChar($entry->charID);
		
		foreach ($UserCaracs as $carac) {
			if ($entry->caracID === $carac->id) {
				$entry->caracVal = $carac->value;
				$entry->caracCond = $carac->cond;
			}
		}


		if ($entry->GM == 1) {
			$entry->type = "drGM";
		}else{
			$entry->type = "drPlayer";
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
		AND ($last->type == 'rpPlayer' OR $last->type == 'drPlayer')
		OR ($last->type == 'drGM' AND $entry->type == 'drGM')) {
			$entry->postID = $last->postID;
		} else {
			$entry->postID = $last->postID+1;
		}

		$this->entries->add($entry);
		
	}

	public function post(){

		$entry = new EntriesEntity;

		$entry->avID = $_POST['avID'];
		$entry->charID = $_POST['charID'];
		$entry->content = $_POST['content'];

		$userChar = $this->characters->findByUserAndAv($_POST['avID']);
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
