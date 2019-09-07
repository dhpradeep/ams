<?php

class Admin extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		header("Location: ".SITE_URL."/admin/setting");
	}

	public function setting() {
		if(Session::isLoggedIn(1)) {
			$all = $this->model->getAllData('program');
			$this->model->data['program'] = $all;
			$this->model->template = VIEWS_DIR.DS."admin".DS."setting.php";
			$this->view->render();
		}else {
			header("Location: ".SITE_URL."/home/dashboard");
		}
	}

}

?>