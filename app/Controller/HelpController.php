<?php

namespace app\Controller;
use app\Manager;
use app\Controller\AppController;

/**
 * 
 */
class HelpController extends AppController
{
	
	protected $mainName = 'help';

	public function __construct(){
		parent::__construct();
	}

	public function show()
	{
		$this->render($this->mainName, null);
	}

}