<?php

namespace app\Controller;
use app\Manager;
use app\Controller\AppController;
use app\Controller\PostController;

/**
 * 
 */
class AvController extends AppController
{

	private $postsPerPage = 6;
	
	public function __construct(){
		parent::__construct();
		$this->loadModel('aventures');
		$this->loadModel('entries');
		$this->loadModel('users');
		$this->loadModel('characters');
		$this->loadModel('carac');
	}


	private function formatEntry($aventure, $post, $entry){

		if ($entry->type == 'rpPlayer') {
			$HTML = $this->getPV('aventures.posts.rpPlayer', $entry);
		}
		elseif ($entry->type == 'rpGM') {
			$HTML = $this->getPV('aventures.posts.rpGM', $entry);
		}
		elseif ($entry->type == 'drGM') {
			$HTML = $this->getPV('aventures.posts.drGM', compact('post', 'entry'));
		}
		elseif ($entry->type == 'drPlayer') {
			$HTML = $this->getPV('aventures.posts.drPlayer', compact('entry', 'post'));
		}
		elseif ($entry->type == 'log') {
			$HTML = $this->getPV('aventures.posts.log', $entry);
		}
		elseif($entry->type == 'start'){
			$HTML = 'Le GM n\'a encore posté aucun message, patience !';
		}
		else{
			$HTML = '';
		}

		return $HTML;

	}

	private function formatAvatar($post){

		if ($post->type == 'rpPlayer') {
			$avatarHTML = $this->getPV('aventures.posts.rpPlayer_avatar', $post);
		}
		elseif ($post->type == 'rpGM') {
			$avatarHTML = $this->getPV('aventures.posts.rpGM_avatar', $post);
		}
		elseif ($post->type == 'drGM') {
			$avatarHTML = $this->getPV('aventures.posts.drGM_avatar', $post);
		}
		else {
			$avatarHTML = $this->getPV('aventures.posts.null_avatar', $post);
		}

		return $avatarHTML;

	}


	/**
	 * Baching entries from a specific adventure by separated posts. Each post must regroup all entries in a row from a same user/GM/NPC.
	 *
	 * @param      <array of objects>  $entries  The entries
	 * 
	 * return $posts
	 */
	private function groupByPosts($aventure, $entries){

		$posts = [];

		foreach ($entries as $key => $entry) {
			$userID = $entry->userID;
			$charID = $entry->charID;

			//POST BEGINS
			if ($key == 0 OR $entry->postID > $entries[$key-1]->postID ) {

				//Creation of POST object
				$post = new \stdClass;
				$post->userInfos = $this->users->find($userID);
				if ($post->userInfos) {				# code...
					$post->characterInfos = $this->characters->find($charID);
					$post->characterInfos->caracs = $this->carac->findByChar($charID);
				}
				$post->type = $entry->type;
				$post->date = $entry->date;
				$post->time = $entry->time;
				$post->avatarHTML = '';
				$post->entries = [];

			}

			//SEPARATION between rp entries or log entries
			$entry->separation = False;
			if ($key+1 !== count($entries)) {
				if (($entry->type == 'rpPlayer' 
					OR $entry->type == 'rpGM'
					OR $entry->type == 'log') 
					AND $entry->type == $entries[$key+1]->type) {
					$entry->separation = True;
				}
			}

			//PUSHING entry in entries of the post
			$entry->HTML = $this->formatEntry($aventure, $post, $entry);
			array_push($post->entries, $entry);

			//POST ENDS
			if ($key == count($entries)-1 OR $entry->postID < $entries[$key+1]->postID) {

				//No separation
				$entry->separation = False;

				//Getting content formatted
				$post->avatarHTML = $this->formatAvatar($post);

				//PUSHING post in returned posts
				array_push($posts, $post);
			}
		}
		return $posts;
	}


	public function index(){



		if (Manager::getInstance()->loggedIn()) {
			$this->log('user '.$_SESSION['auth'].' est venu sur la page d\'aventures');
			$aventures = $this->aventures->getAll();
			$this->render('aventures.av_list', $aventures);
		}else{
			$this->log('un inconnu est venu sur la page d\'aventures');
			$this->mustLogIn();
		}
	}

	public function setAventure($avID){

		$aventure = $this->aventures->find($avID);
		$aventure->characters = $this->characters->findByAv($avID);

		foreach ($aventure->characters as $char) {
			$char->caracs = $this->carac->findByChar($char->id);
		}

		$aventure->carac = $this->carac->findByAv($avID);
		$aventure->userChar = $this->characters->findByUserAndAv($avID);

		//Last is user ?
		$aventure->last = $this->entries->lastByAv($avID);
		if ($aventure->last->charID === $aventure->userChar->id) {
			$aventure->lastIsUser = True;
		}else{
			$aventure->lastIsUser = False;
		}

		//User is GM ?
		if ($aventure->userChar->name === 'GM') {
			$aventure->userIsGM = True;
		}else{
			$aventure->userIsGM = False;			
		}

		return $aventure;
	}

	public function show($avID){

		if (Manager::getInstance()->loggedIn()) {
			if($this->characters->findByUserAndAv($avID)){
				$aventure = $this->setAventure($avID);
				$paging = $this->paging($avID);
				$entries = $this->entries->findByPosts($avID, $paging['first'], $paging['last']);
				$posts = $this->groupByPosts($aventure, $entries);

				$HTML = [];
				$HTML['paging'] = $paging['HTML'];
				$HTML['fixInfos'] = $this->getPV('aventures.fixInfos', $aventure);
				$this->render('aventures.av', compact('aventure', 'posts', 'HTML'));
			}else{
				$this->forbidden('Ton personnage ne fais pas partie de l\'aventure ;-)');
			}
		}else{
			$this->mustLogIn();
		}
	}

	private function paging($avID){

		$paging = [];

		$paging['count'] = $this->entries->countPosts($avID);

		$paging['pageCount'] = ceil($paging['count']/$this->postsPerPage);

		if (isset($_GET['p'])) {
			if (!$_GET['p'] > 0 OR $_GET['p'] > $paging['pageCount']) {
				$this->forbidden('Perdu ? =P');
				exit;
			}
			$paging['page'] = $_GET['p'];
		}else{
			$paging['page'] = $paging['pageCount'];
		}

		$paging['last'] = $paging['page'] * $this->postsPerPage;
		$paging['first'] = $paging['last'] - $this->postsPerPage + 1;

		$paging['HTML'] = $this->getPV('templates.paging', $paging);

		return $paging;

	}

}