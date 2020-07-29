<?php

namespace app\Controller;
use app\Controller\AppController;

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