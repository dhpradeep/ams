<?php

abstract class Controller {
	protected $model;
	protected $view;
	protected $foreignModel = null;

	public function __construct() {
		$this->model = $this->setModel("CommonModel");
		$this->view = $this->setView(get_class($this)."View", $this->model, $this);
	}

	protected function setModel($model) {
		require_once MODELS_DIR.DS.$model.'.php';
		return new $model();
	}

	protected function setView($view, $model,$controller) {
		require_once VIEWS_DIR.DS.$view.'.php';
		return new $view($model,$controller);
	}

}

?>