<?php


namespace core\Controller;

/**
 * 
 */
class Controller{
	
	
	protected $viewpath;
	protected $template;

	public function render($view, $variables){

		echo "render called";

/*		ob_start();
		require ($this->viewpath . str_replace('.', '/', $view) . '.php');
		$content = ob_get_clean();
		require($this->viewpath . 'templates/' . $this->template . '.php');*/

	}

	public function getPV($partialView, $variables){

		ob_start();
		require ($this->viewpath . str_replace('.', '/', $partialView) . '.php');
		return ob_get_clean();

	}

}