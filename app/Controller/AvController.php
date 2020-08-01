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
	
	public function __construct(){
		parent::__construct();
		$this->loadModel('aventures');
		$this->loadModel('entries');
		$this->loadModel('users');
		$this->loadModel('characters');
	}


	private function formatEntry($post, $entry){

		if ($entry->type == 'rpPlayer') {
			$HTML = $this->getPV('aventures.posts.rpPlayer', $entry);
		}
		elseif ($entry->type == 'rpGM') {
			$HTML = $this->getPV('aventures.posts.rpGM', $entry);
		}
		elseif ($entry->type == 'drGM') {
			$HTML = $this->getPV('aventures.posts.drGM', compact('entry', 'post'));
		}
		elseif ($entry->type == 'drPlayer') {
			$HTML = $this->getPV('aventures.posts.drplayer', compact('entry', 'post'));
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
	private function groupByPosts($entries){

		echo "AvController.groupByPosts --- ";

		$posts = [];

		foreach ($entries as $key => $entry) {

			$userID = $entry->userID;
			$characterID = $entry->characterID;

			//POST BEGINS
			if ($key == 0 OR $entry->postID > $entries[$key-1]->postID ) {

				//Creation of POST object
				$post = new \stdClass();
				$post->userInfos = $this->users->find($userID);
				$post->characterInfos = $this->characters->find($characterID);
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


			//SEPARATION between rp entries
			if (($entry->type == 'rpPlayer' OR $entry->type == 'rpGM') 
				AND $entry->type == $entries[$key+1]->type) {
				$entry->separation = True;
			} else{
				$entry->separation = False;
			}

			//PUSHING entry in entries of the post
			$entry->HTML = $this->formatEntry($post, $entry);
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

	public function setSession(){
	}


	public function index()
	{
		$aventures = $this->aventures->getAll();
		$this->render('aventures.av_list', $aventures);
	}


	public function show($avID)
	{
		echo "avController.show --- ";
		$aventure = $this->aventures->find($avID);
		$entries = $this->entries->getAllByAv($avID);
		$posts = $this->groupByPosts($entries);
		echo "Av.Controller pre-render";
		$this->render('aventures.av', compact('aventure', 'posts'));
	}

}