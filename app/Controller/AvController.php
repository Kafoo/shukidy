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
			$HTML = $this->getPV('aventures.posts.drGM', compact('aventure', 'post', 'entry'));
		}
		elseif ($entry->type == 'drPlayer') {
			$HTML = $this->getPV('aventures.posts.drPlayer', compact('entry', 'post'));
		}
		elseif ($entry->type == 'log') {
			$HTML = $this->getPV('aventures.posts.log', $entry);
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
				$post->characterInfos = $this->characters->find($charID);
				$post->type = $entry->type;
				$post->dat = $entry->dat;
				$post->avatar = True;
				$post->avatarHTML = '';
				$post->entries = [];

				//No avatar for specific kind of post
				if ($entry->type == "log") {
					$post->avatar = False;
				}
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

		$aventures = $this->aventures->getAll();
		$this->render('aventures.av_list', $aventures);
	}

	public function setAventure($avID){
		$aventure = $this->aventures->find($avID);
		$aventure->characters = $this->characters->findByAv($avID);
		$aventure->carac = $this->carac->findByAv($avID);
		$aventure->lastIsUser = False;
		$aventure->userIsGM = True;

		foreach ($aventure->characters as $character) {
			if ($character->userID == $_SESSION['auth']) {
				$aventure->userChar = $character;
			}
		}

		return $aventure;
	}

	public function show($avID){

		if (!Manager::getInstance()->loggedIn()) {
			$this->mustLogIn();
		}else{		
			$aventure = $this->setAventure($avID);
			$paging = $this->paging($avID);
			$entries = $this->entries->findByPosts($avID, $paging['first'], $paging['last']);
			$posts = $this->groupByPosts($aventure, $entries);

			$HTML = [];
			$HTML['paging'] = $paging['HTML'];
			$HTML['fixInfos'] = $this->getPV('aventures.fixInfos', $aventure);
			$this->render('aventures.av', compact('aventure', 'posts', 'HTML'));
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
			$paging['page'] = 1;
		}

		$paging['last'] = $paging['page'] * $this->postsPerPage;
		$paging['first'] = $paging['last'] - $this->postsPerPage + 1;

		$paging['HTML'] = $this->getPV('templates.paging', $paging);

		return $paging;

	}

}