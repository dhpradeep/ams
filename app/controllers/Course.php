<?php

class Course extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		
		$this->model->template = VIEWS_DIR.DS."course".DS."course.php";
		$this->view->render();
	}
	public function course() {
		$this->model->template = VIEWS_DIR.DS."course".DS."course.php";
		$this->view->render();
	}

}

?>