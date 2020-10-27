<?php


namespace core\Controller;

/**
 * 
 */
class Controller{
	
	
	protected $viewpath;
	protected $template;

	public function render($view, $variables = null){

		ob_start();
		require ($this->viewpath . str_replace('.', '/', $view) . '.php');
		$content = ob_get_clean();
		require($this->viewpath . 'templates/' . $this->template . '.php');
	}

	public function forbidden($error = null){
		header('HTTP/1.0 403 Forbidden');
		$this->render('403', $error);
	}

	public function mustLogIn($error = 'Tu dois être connecté pour accéder à cette page !'){
		header('HTTP/1.0 403 Forbidden');
		$this->render('403', $error);
	}

	public function notFound($error = null){
		header('HTTP/1.0 404 Not Found');
		$this->render('404', $error);
	}

	public function getPV($partialView, $variables = null){
		ob_start();
		require ($this->viewpath . str_replace('.', '/', $partialView) . '.php');
		return ob_get_clean();

	}

}