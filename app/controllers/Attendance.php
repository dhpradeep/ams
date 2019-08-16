<?php

class Attendance extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		
		$this->model->template = VIEWS_DIR.DS."attendance".DS."attendance.php";
		$this->view->render();
	}
	public function attendance() {
		$this->model->template = VIEWS_DIR.DS."attendance".DS."attendance.php";
		$this->view->render();
	}

}

?>