<?php

namespace app\Controller;
use app\Manager;
use app\Controller\AppController;

/**
 * 
 */
class ProfilController extends AppController
{
	
	protected $mainName = 'profil';

	public function __construct(){
		parent::__construct();
		$this->loadModel('users');
		$this->loadModel('characters');
	}

	public function show($userID)
	{
		$user = $this->users->find($userID);
		$characters = $this->characters->getAllByUser($userID);
		$this->render($this->mainName, compact('user', 'characters'));
	}

}