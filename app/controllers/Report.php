<?php

class Report extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		header("Location: ".SITE_URL."/report/view");
	}

	public function view($name = "") {
		$this->model->setTable('attendance');
		if(($name == "get1") && (Session::isLoggedIn(1))) {
			$result = array('status' => 0);	
			if(isset($_POST) && count($_POST) > 0) {
				if($name == "get1") {
					return $this->getStudentOverview($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}
		} else if($name == ''){	
			if(Session::isLoggedIn(1)) {
				$allStudents = count($this->model->searchData('userlogin', array("role" => 3)));
				$this->model->data['noOfStudents'] = $allStudents;
				$this->model->data['noOfTeachers'] = count($this->model->getAllData('userlogin')) - $allStudents;
				$this->model->data['noOfPrograms'] = count($this->model->getAllData('program'));
				$this->model->data['noOfSubjects'] = count($this->model->getAllData('subjects'));

				$all = $this->model->getAllData('program');
				$this->model->data['program'] = $all;

				$this->model->template = VIEWS_DIR.DS."report".DS."report.php";
        		$this->view->render();
			}else {
				header("Location: ".SITE_URL."/home/dashboard");
			}			
		} else {
			header("Location: ".SITE_URL."/home/message");
		}	
    }

    private function getStudentOverview($result) {
		$arr = array();
		$total = 0;
		$index = 0;
		$startDate = Sanitize::escape($_POST['startDate']);
		$endDate = Sanitize::escape($_POST['endDate']);

		$allSubjects = $this->model->searchData("subjects", array("sectionId" => Sanitize::escape($_POST['sectionId'])));
		$allStudents = $this->model->searchData("personaldata", array("sectionId" => Sanitize::escape($_POST['sectionId'])));

		if(strlen($startDate) == 10 && strlen($endDate) == 10) {
			if(count($allSubjects) != 0) {
				if(count($allStudents) != 0) {
					$records = $this->initializeArray($allStudents, $allSubjects);
					$allSubjectsId = array();
					$allUsersId = array();
					foreach ($records as $userId => $subArray) {					
						foreach ($subArray as $subjectId => $value) {
							$records[$userId][$subjectId] = rand(15,30); //count($this->model->rangeData("attendance" ,"date",$startDate,$endDate, array('userId' => $userId, "subjectId" => $subjectId, "status" => 1)));
							array_push($allSubjectsId, $subjectId);
							array_push($allUsersId, $userId);
						}
					}

					$allStudents = $this->getNamesArray($allUsersId, "userlogin", 1);
					asort($allStudents);
					$allSubjects = $this->getNamesArray($allSubjectsId, "subjects", 0);

					$arr = $records;
					$result['data']['subjectNames'] = $allSubjects;
					$result['data']['studentNames'] = $allStudents;
				}else {
					$result["error"] = "No Student Found !";
				}
			}else {
				$result["error"] = "No Subject Found !";
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

    private function getNamesArray($arr, $tableName, $mode) {
    	$output = array();
    	if(count($arr) > 0) {
    		foreach ($arr as $key => $value) {
    			$oneRow = $this->model->getData($tableName, array('id' => $value));
    			$name = "";
    			if($mode == 1) {
    				$name = ($oneRow != null) ? $oneRow['fname'].' '.$oneRow['mname'].' '.$oneRow['lname'] : "Unkown";
    			}else {
    				$name = ($oneRow != null) ? $oneRow['name'] : "Unkown";
    			}
    			$output[$value] = $name;
    		}
    	}
    	return $output;
    }


    private function initializeArray($students, $subjects) {
		$categories = array();
		$finalOutput = array();
		foreach ($students as $value) {
			if(!(in_array($value['userId'], $categories))) {
				array_push($categories, $value['userId']);
				$finalOutput[$value['userId']] = array();
			}
			foreach ($subjects as $sub) {
				$finalOutput[$value['userId']][$sub['id']] = 0;		
			}			
		}
		return $finalOutput;
	}


}
?>