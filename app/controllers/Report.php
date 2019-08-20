<?php

class Report extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		header("Location: ".SITE_URL."/report/view");
	}

	public function view() {
        $this->model->template = VIEWS_DIR.DS."report".DS."report.php";
        $this->view->render();	
    }
}
?>