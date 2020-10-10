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

	public function avatar($avatar){
		return $this->imgPath . 'avatars/' . str_replace('.', '/', $avatar) . '.jpg';
	}

	public function icon($icon){
		return $this->imgPath . 'icons/' . str_replace('.', '/', $icon) . '.png';
	}

	public function gameicon($icon){
		return $this->imgPath . 'gameicons/' . $icon;
	}

	public function carac($icon, $color){
		$url = $this->imgPath . 'gameicons/' . $icon;
		return 'style="background-image: url('.$url.'); background-color: '.$color.'"';
	}

	public function rpg($img){
		return $this->imgPath . 'rpg/' . $img . '.png';
	}

}