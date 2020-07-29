<?php

namespace App\Controller;
use Core\Controller\Controller;
use App\Manager;

/**
 * 
 */
class AppController extends Controller{
	

	protected $template = 'default';
	protected $mainName;

	public function __construct(){

		$this->viewpath = ROOT . '/app/Views/';
		$this->imgRelPath = 'img/';

	}

	protected function loadModel($model_name){

		$this->$model_name = Manager::getInstance()->getTable($model_name);

	}

	public function index()
	{
		$this->render($this->mainName, null);
	}

	
}