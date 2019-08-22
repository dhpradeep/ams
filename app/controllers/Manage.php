<?php

class Manage extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		header("Location: ".SITE_URL."/manage/program");
	}

	public function program() {
		$this->model->template = VIEWS_DIR.DS."manage".DS."program.php";
		$this->view->render();
	}

	public function subject() {
		$this->model->template = VIEWS_DIR.DS."manage".DS."subject.php";
		$this->view->render();
	}

	public function section() {
		$this->model->template = VIEWS_DIR.DS."manage".DS."section.php";
		$this->view->render();
	}
}

?>