<?php

namespace App\Controller;
use App\Controller\AppController;

/**
 * 
 */
class ImgController extends AppController
{


	public function __construct(){
		parent::__construct();
	}

	public function getAvatar($avatar){
		return $this->imgRelPath . 'avatars/' . str_replace('.', '/', $avatar) . '.jpg';
	}


}