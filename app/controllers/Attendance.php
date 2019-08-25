<?php

class Attendance extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		header("Location: ".SITE_URL."/attendance/attendance");
	}
	public function attendance($name = '') {
		$this->model->setTable('attendance');
		if(($name == "get" || $name == "set") && (Session::isLoggedIn(1) || Session::isLoggedIn(2))) {
			$result = array('status' => 0);	
			if(isset($_POST) && count($_POST) > 0) {
				if($name == "get") {
					return $this->getAttendance($result);
				}else if($name == "set") {
					return $this->setAttendance($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}
		} else if($name == ''){	
			if(Session::isLoggedIn(1) || Session::isLoggedIn(2)) {
				$subjects = $this->model->searchData('subjectassign', array('userId' => Session::getSession('uid')));
				$subjectsDetails = array();
				if(count($subjects) > 0) {
					foreach ($subjects as $key => $value) {
						$one = $this->model->getData('subjects', array('id' => $value['subjectId']));
						if($one != null) {
							$programDetail = $this->model->getData('program', array('id' => $one['programId']));
							if($programDetail != null) {
								$one['programName'] = $programDetail['name'];
							}
							$sectionDetail = $this->model->getData('section', array('id' => $one['sectionId']));
							if($sectionDetail != null) {
								$one['sectionName'] = $sectionDetail['name'];
							}
							array_push($subjectsDetails, $one);
						}
					}
				}else {
					$this->model->data['errors'] = "No subject assigned";
				}
				$this->model->data['subjects'] = $subjectsDetails;
				$this->model->template = VIEWS_DIR.DS."attendance".DS."attendance.php";
				$this->view->render();
			}else {
				header("Location: ".SITE_URL."/user/login");
			}			
		} else {
			header("Location: ".SITE_URL."/home/message");
		}
	}

	 private function getAttendance($result) {
		$arr = array();
		$date = Input::get('date');
		$string = explode("-", $date);
		$string = checkdate((int) $string[1],(int) $string[2],(int) $string[0]);
		$subjectId = Input::get('subjectId');

		$section = $this->model->getData('subjects', array('id' => $subjectId));		

		if(strlen($date) == 10 && $string == true) {
			if($section != null) {
				$allStudents = $this->model->searchData("personaldata", array("sectionId" => $section['sectionId'] ));
				if(count($allStudents) != 0) {
					$toReturn = array();
					$records = array();
					$found = 0;
					foreach ($allStudents as $key => $value) {
						$oneRow = $this->model->getData('userlogin', array('id' => $value['userId'])); 
						$records['name'] = ($oneRow != null) ? $oneRow['fname'].' '.$oneRow['mname'].' '.$oneRow['lname'] : "Unkown";
						$records['userId'] = $value['userId'];
						$recordRow = $this->model->getData('attendance', array(
											'userId' => $value['userId'],
											'subjectId' => $subjectId,
											'date' => $date
										));
						if($recordRow != null) {
							$records['status'] = $recordRow['status'];
							$found = 1;
						}else {
							$records['status'] = 0;
						}
						array_push($toReturn, $records);						 
					}

					$arr = $toReturn;
					$result['data']['found'] = $found;
					$result['data']['subjectId'] = $subjectId;
					$result['data']['date'] = $date;
				}else {
					$result["error"] = "No Student Found !";
				}
			}else {
				$result["error"] = "Subject Invalid! No section found!";
			}
		}else {
			$result["error"] = "Date invalid";
		}
			

		if(count($arr) >= 1){
			$result['status'] = 1;
		}
		$result['data']['records'] = $arr;
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
    }


    private function setAttendance($result) {
		$arr = array();
		$date = Input::get('date');
		$string = explode("-", $date);
		$string = checkdate((int) $string[1],(int) $string[2],(int) $string[0]);
		$subjectId = Input::get('subjectId');

		$section = $this->model->getData('subjects', array('id' => $subjectId));		

		if(strlen($date) == 10 && $string == true) {
			if($section != null) {
				if(count($_POST['status']) > 0) {
					$count = 0;
					$oneCount = 0;
					foreach ($_POST['status'] as $key => $value) {
						$userId = Sanitize::escape($value['userId']);
						$status = Sanitize::escape($value['status']);
						$getOne = $this->model->getData('attendance', array(
							'userId' => $userId,
							'subjectId' => $subjectId,
							'date' => $date
						));
						if($getOne != null) {
							$oneCount = 1;
							$this->model->updateData('attendance', $getOne['id'], array('status' => $status));
						}else {
							$oneCount = $this->model->registerData('attendance', array(
								'userId' => $userId,
								'subjectId' => $subjectId,
								'date' => $date,
								'status' => $status
							));
						}
						$count = ($oneCount != 0) ? $count + 1 : $count;
					}
					if($count == count($_POST['status'])) {
						$result['status'] = 1;
					}
				}else {
					$result["error"] = "No data sent!";
				}
			}else {
				$result["error"] = "Subject Invalid! No section found!";
			}
		}else {
			$result["error"] = "Date invalid";
		}

		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
    }

}

?>