<?php

class Home extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		header("Location: ".SITE_URL."/home/dashboard");
	}

	public function dashboard() {
		if(!Session::isloggedIn()) {
			header("Location: ".SITE_URL."/user/login");
		}else if(Session::isloggedIn(2)) {
			header("Location: ".SITE_URL."/attendance/attendance");
		} else {
			$this->model->data['errors'] = array();
			$userId = Session::getSession('uid');
			$userRole = Session::getSession('role');
			$userProgram = null;
			if(!is_null($userId) && !is_null($userRole)) {
				if($userRole == 1 ) {
					array_push($this->model->data['errors'], "<a href ='".SITE_URL."/attendance/attendance'> Click here to go to Attendance View</a>");
				}else if($userRole == 3) {
					header("Location: ".SITE_URL."/test");
				}else {
					array_push($this->model->data['errors'], "No valid role for User!");
				}
				$this->model->template = VIEWS_DIR.DS."home".DS."dashboard.php";
				$this->view->render();
			}else {
				header("Location: ".SITE_URL."/user/login");
			}
		}		
	}

	public function message($name = '', $code='') {
		if(!empty($name)) {
			$code = (!empty($code)) ? $code : 404;
			$this->model->data = array(
			'message'=> array(
			'header' => 'Error '.$code,
			'content' => '<b>'.$name.'!</b>',
			'link' => SITE_URL,
			'link_content' => 'Go to home'
			));
		}
		$this->model->template = VIEWS_DIR.DS."error.php";
		$this->view->render();
	}

	private function setDataToTable($tableName, $data) {
		$this->setForeignModel("StudentModel");
		$this->foreignModel->setTable($tableName);
		return $this->foreignModel->registerStudent($data);
	}

	private function updateDataToTable($tableName, $id, $data) {
		$this->setForeignModel("StudentModel");
		$this->foreignModel->setTable($tableName);
		return $this->foreignModel->updateStudent($id, $data);
	}

	private function deleteDataFromTable($tableName, $id) {
		$this->setForeignModel("StudentModel");
		$this->foreignModel->setTable($tableName);
		return $this->foreignModel->deleteStudent($id);
	}

	private function searchDataFromTable($tableName, $data) {
		$this->setForeignModel("StudentModel");
		$this->foreignModel->setTable($tableName);
		return $this->foreignModel->searchStudent($data);
	} 

	private function getPKFromTable($tableName, $data) {
		$this->setForeignModel("StudentModel");
		$this->foreignModel->setTable($tableName);
		return $this->foreignModel->getStudentId($data);
	}
}

?>