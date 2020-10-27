<?php

namespace app\Controller;
use core\Controller\Controller;
use app\Controller\MailController;
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
		$this->loadModel('log');

	}

	protected function loadModel($model_name){

		$this->$model_name = Manager::getInstance()->getTable($model_name);

	}

	public function mail($subject, $msg){

		$mail = new MailController;
		$mail->send($subject, $msg, ['ant.guillard@gmail.com']);
	}

	public function log($msg){
		$this->log->add($msg);

		$mail = new MailController;
		$mail->send('nouveau log sur Shukidy!', $msg, ['ant.guillard@gmail.com']);

	}

	public function showLog(){
		$logs = $this->log->getAll();
		$this->render('log', $logs);
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