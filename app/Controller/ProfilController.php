<?php

namespace app\Controller;
use app\Controller\AppController;
use app\Manager;

/**
 * 
 */
class ProfilController extends AppController{
	
	protected $mainName = 'profil';

	public function __construct(){
		parent::__construct();
		$this->loadModel('users');
		$this->loadModel('characters');
	}

	public function show()
	{

		if (Manager::getInstance()->loggedIn()) {

			$userID = $_SESSION['auth'];
			$user = $this->users->find($userID);

			if ($user) {		
				$characters = $this->characters->findByUser($userID);
				$this->render($this->mainName, compact('user', 'characters'));
			}else{
				$this->notFound('User not found');
			}
		}else{
			$this->mustLogIn();
		}

	}
}