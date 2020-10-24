<?php

namespace app\Controller;
use core\Controller\Controller;
use app\Manager;

/**
 * 
 */
class AppController extends Controller{
	

	protected $template = 'default';
	protected $mainName;

	public function __construct(){

		$this->viewpath = ROOT . '/app/views/';
		$this->imgPath = '/public/img/';

	}

	protected function loadModel($model_name){

		$this->$model_name = Manager::getInstance()->getTable($model_name);

	}

	public function index(){
		$this->render($this->mainName, null);
	}

	public function hydrate($object, $prop, $value){
		
		$method = 'set'.ucfirst($prop);
		if (method_exists ($object , $method )) {
			$object->$method($value);
		}else{
			$object->$prop = $value;
		}
	}
	
}