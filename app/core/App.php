<?php

class App {

	protected $controller = 'Home';
	protected $method = 'index';
	protected $params = [];

	public function __construct() {
		if(!isset($_SESSION)) {
			session_start();
		}		
		$url = $this->parseurl();

		if(isset($url[0]) && file_exists(CONTROLLERS_DIR.DS.ucwords($url[0]). '.php')) {
			$this->controller = ucwords($url[0]);
			unset($url[0]);
		}

		require_once CONTROLLERS_DIR.DS. $this->controller. '.php';
		$this->controller = new $this->controller;

		try{
			if(isset($url[1])) {
				$method = new ReflectionMethod($this->controller, $url[1]);
				$params = $method->getParameters();
				if(isset($url[2]) && sizeof($params) <= 0) {
					$this->setDefault(0);
				} else {
					$this->method = $url[1];
				}
				unset($url[1]);
			}						
		} catch(ReflectionException $e) {
			$this->setDefault(0);
		}	



		$this->params = $url ? array_values($url) : [];

		set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext) {
		    if (0 === error_reporting()) {
		        return false;
		    }
		    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		});

		try {
			call_user_func_array([$this->controller, $this->method], $this->params);
		}catch(ErrorException $e) {
			if($e->getFile() == __FILE__) {
				$this->params = array("No permission to load page", 103);
			} else {
				$this->params = array($e->getMessage()."\n<br> File: ".$e->getFile()." Line : ".$e->getLine(), 104);
			}
			$this->setDefault(0);			
			call_user_func_array([$this->controller, $this->method], $this->params);
		}

	}

	private function setDefault($mode) {
		$this->controller = 'Home';
		require_once CONTROLLERS_DIR.DS. $this->controller. '.php';
		$this->controller = new $this->controller;
		$this->method = 'message';
	}

	public function parseUrl() {
		if(isset($_GET['url'])) {
			$url = explode('/',filter_var($_GET['url'], FILTER_SANITIZE_URL));
			return $url;
		}
	}
}

?>