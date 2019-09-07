<?php

class Student extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		header("Location: ".SITE_URL."/student/all");
	}

	public function upgrade($name = "") {
		if($name == "program") {
			if(Session::isLoggedIn(1) && isset($_POST) && count($_POST) > 0) {
				$result = array('status' => 0);
				$programId = Input::get("programId");
				$details = $this->model->getData("program", array("id" => $programId));
				if($details != null) {
					$getAllStudents = $this->model->searchData('personaldata', array('programId' => $programId));
					$count = 0; $changes = 0;
					if(count($getAllStudents) > 0) {
						foreach ($getAllStudents as $key => $value) {
							$oldValue = $value['yearOrSemester'];
							if($oldValue > 0) {// Not Passout
								/*if($oldValue < $details['noOfYearOrSemester']) {
									$newValue = $oldValue + 1;
								}*/
								if($oldValue == $details['noOfYearOrSemester']) {
									$count++;
									$newValue = -2;
									$update = $this->model->updateData('personaldata', $value['id'] ,array('yearOrSemester' => $newValue));
									if($update == 1 ) $changes++;
								}
							}
							
						}
						if($count == $changes) {
							$result['status'] = 1;
						}else {
							$result['error'] = "Problem with connection";
						}
					}else {
						$result['error'] = "No student are enrolled !";
					}	
				}else {
					$result['error'] = "Program not found !";
				}
				$result['success'] = ($result['status'] == 1) ? true : false;
				unset($_POST);
				return print json_encode($result);				
			}else {
				header("Location: ".SITE_URL."/home/message");
			}
		}else {
			header("Location: ".SITE_URL."/home/message");
		}
	}

	public function all($name = "") {
		if(($name == "add" || $name == "update" || $name == "delete" || $name == "get" || $name == "getSections") && Session::isLoggedIn(1)) {
			$result = array('status' => 0);	
			if(isset($_POST) && count($_POST) > 0) {
				if($name == "get") {
					return $this->getStudent($result);
				}
				if($name == "delete") {
					return $this->deleteStudent($result);
				}
				if($name == "update" && isset($_POST['id'])) {
					return $this->updateStudent($result);
				}
				if($name == "add") {
					return $this->addStudent($result);
				}
				if($name == "getSections" && isset($_POST['programId'])) {
					return $this->getSectionsPrivate($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}		

		} else if($name == ''){	
			if(Session::isLoggedIn(1)) {
				$all = $this->model->getAllData('program');
				$this->model->data['program'] = $all;
				$this->model->template = VIEWS_DIR.DS."students".DS."students.php";
				$this->view->render();
			}else {
				header("Location: ".SITE_URL."/home/dashboard");
			}			
		} else {
			header("Location: ".SITE_URL."/home/message");
		}
    }

    private function getSectionsPrivate($result) {
    	if(!isset($_POST['programId']) || !isset($_POST['yearOrSemester'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$programId = Input::get('programId');
			$yearOrSemester = Input::get('yearOrSemester');
			$dataToSearch = array('programId' => $programId, 'yearOrSemester' => $yearOrSemester);
			$res = $this->model->searchData('section',$dataToSearch);
			if(count($res) > 0) {
				$result['sections'] = $res;
				$result['status'] = 1;
			}else if($yearOrSemester == -2) {
				$lastSem = $this->model->getData("program" , array('id' => $programId));
				if($lastSem != null) {
					$result['sections'] = $this->model->searchData("section", array('programId' => $programId ,
											'yearOrSemester' => $lastSem['noOfYearOrSemester']));
				}else {
					$result['sections'] = array(array('id' => -2, 'name' => "Unknown"));
				}			
				$result['status'] = 1;
			}else {
				$result['error'] = array("Section not found for this program and semester/year.");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
    }

    private function getStudent($result) {
		$startIndex = $_POST['start'];
		$totalCount = $_POST['length'];
		$startIndex = ($totalCount == -1) ? 0 : $startIndex;
		$columnToSort = null;
		$sortDir = null;
		$stringToSearch = null;
		$fieldToSearch = array("fname","username","email","lname");
		if(isset($_POST["search"]["value"])) {
			$stringToSearch = Sanitize::escape($_POST["search"]["value"]);
		}
		$result2 = $this->model->getAllDataConditions('userlogin' ,$stringToSearch,$fieldToSearch,$columnToSort,$sortDir);
		$onlyStudent = array();
		$index = 0;
		$i = 0;
		foreach ($result2 as $value) {
			if($value['role'] == 3) {
				$onlyStudent[$index++] = $result2[$i];
			}
			$i++;
		}
		$total = $index;
		$userIdArray = array();
		$res = array();
		if($total > 0) {
			foreach ($onlyStudent as $value) {
				array_push($userIdArray, $value['id']);
			}
		}

		$res = $this->getAllStudentRecords($userIdArray);

		$totalCountWithoutFilter = count($res);

		if(isset($_POST['filterDataProgram']) && $_POST['filterDataProgram'] > 0) {
			$i = 0;
			foreach ($res as $value) {
				if($value['programId'] != $_POST['filterDataProgram']) {
					array_splice($res, $i, 1);
					$i--;
				}
				$i++;
			}
		}

		if(isset($_POST['filterDataStatus']) && ($_POST['filterDataStatus'] == "true" || $_POST['filterDataStatus'] == "false")) {
			$i = 0;
			foreach ($res as $value) {
				if($value['status'] != $_POST['filterDataStatus']) {
					array_splice($res, $i, 1);
					$i--;
				}
				$i++;
			}
		}

		if(isset($_POST['filterDataSemester']) && $_POST['filterDataSemester'] > 0) {
			$i = 0;
			foreach ($res as $value) {
				if($value['yearOrSemester'] != $_POST['filterDataSemester']) {
					array_splice($res, $i, 1);
					$i--;
				}
				$i++;
			}
		}

		if(isset($_POST['filterDataSection']) && $_POST['filterDataSection'] > 0) {
			$i = 0;
			foreach ($res as $value) {
				if($value['sectionId'] != $_POST['filterDataSection']) {
					array_splice($res, $i, 1);
					$i--;
				}
				$i++;
			}
		}

		$total = count($res);
		$index = 0;
		$arr = array();
		$totalCount = ($totalCount == -1) ? $total : $totalCount;
		for ($i = $startIndex; $i < $startIndex + $totalCount && $i < $total; $i++){
			$arr[$index] = $res[$i];
			$arr[$index]['id'] = $arr[$index]['userId'];
			$arr[$index]['name'] = $arr[$index]['fname']." ".$arr[$index]['mname']." ".$arr[$index]['lname'];
			unset($arr[$index]['passwordHash']);
			unset($arr[$index]['username']);
			unset($arr[$index]['password']);
			unset($arr[$index]['role']);

			$arr[$index]['levelName'] = ($arr[$index]['level'] == 1) ? "SLC" : "Unkown";			
			switch ($arr[$index]['gender']) {
				case 1:
					$arr[$index]['genderName'] = "Male";
					break;
				case 2:
					$arr[$index]['genderName'] = "Female";
					break;
				default:
					$arr[$index]['genderName'] = "Others";					
			}
			$toSearch = array("id" => $res[$i]['programId']);
			$programs = $this->model->searchData('program', $toSearch);
			if(count($programs) > 0) {
				$arr[$index]['programName'] = $programs[0]['name'];
			}else {
				$arr[$index]['programName'] = "Unkown";
			}
			$toSearch = array("id" => $res[$i]['sectionId']);
			$sections = $this->model->searchData('section', $toSearch);
			if(count($sections) > 0) {
				$arr[$index]['sectionName'] = $sections[0]['name'];
			}else {
				$arr[$index]['sectionName'] = "Unkown";
			}	
			$index++;
		}

		$name  = array_column($arr, 'name');
		$sectionName = array_column($arr, 'sectionName');
		$yearOrSemester = array_column($arr, 'yearOrSemester');
		$rollNo = array_column($arr, 'rollNo');
		$toSort = (isset($_POST["order"][0]["column"])) ? $_POST["columns"][$_POST["order"][0]["column"]]["data"] : $name;
		if(isset($_POST["order"][0]["dir"]) && ($toSort == "name" || $toSort == "sectionName" || $toSort == "yearOrSemester" || $toSort == "rollNo")) {
			if($_POST["order"][0]["dir"] == "asc")
				array_multisort($$toSort, SORT_ASC, $arr);
			else
				array_multisort($$toSort, SORT_DESC, $arr);
		}

		if(count($arr) >= 1){
			$result['status'] = 1;
		}
		$result['data'] = $arr;
		$result['success'] = ($result['status'] == 1) ? true : false;
		$result['draw'] = $_POST['draw'];
		$result['recordsTotal'] = $totalCountWithoutFilter;
		$result['recordsFiltered'] = $total;
		unset($_POST);
		return print json_encode($result);
	}

	private function getAllStudentRecords($idArray){
		$total = array();
		$tableName = array("personaldata","contactdetails","education");
		foreach ($idArray as $id) {
			$one = array();
			$res = $this->model->searchData("userlogin", array("id" => $id));
			if(count($res) > 0) {
				foreach ($res[0] as $key => $value) {
					$one[$key] = $value;
				}
			}
			foreach ($tableName as $table) {
				$result = $this->model->searchData($table, array("userId" => $id));
				if(count($result) > 0) {
					foreach ($result[0] as $key => $value) {
						$one[$key] = $value;
					}
				}				
			}
			array_push($total, $one);
		}
		return $total;
	}

	private function deleteStudent($result) {
		if(!isset($_POST['id'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$idToDel = Input::get('id');
			$dataToSearch = array('id' => $idToDel);
			$res = $this->model->searchData('userlogin',$dataToSearch);
			if(count($res) >= 1) {
				$out = $this->model->deleteData("userlogin", $idToDel);
				$pk = $this->model->getDataId("personaldata",array('userId' => $idToDel));
				if($pk != 0) $this->model->deleteData("personaldata", $pk);
				$pk = $this->model->getDataId("contactdetails",array('userId' => $idToDel));
				if($pk != 0) $this->model->deleteData("contactdetails", $pk);
				$pk = $this->model->getDataId("education",array('userId' => $idToDel));
				do {
					if($pk != 0) $this->model->deleteData("education", $pk);
					$pk = $this->model->getDataId("education",array('userId' => $idToDel));
				}while($pk != 0);
				$pk = $this->model->getDataId("attendance",array('userId' => $idToDel));
				do {
					if($pk != 0) $this->model->deleteData("attendance", $pk);
					$pk = $this->model->getDataId("attendance",array('userId' => $idToDel));
				}while($pk != 0);
				$result['status'] = 1;		
			}else {
				$result['error'] = array("No such student found.");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
	}

	private function updateStudent($result) {
		$validate = new Validator();
		$validation = $validate->check($_POST, $this->getValidators());
		if($validate->passed()){
			$dataForSearch = array('id' => $_POST['id']);
			$res = $this->model->searchData('userlogin', $dataForSearch);
			if(count($res) >= 1) {
				$idToUpdate = $_POST['id'];
				$data = array();
				$data['id'] = null;
				foreach ($_POST as $key => $value) {
					if(gettype($value) == "boolean" || gettype($value) == "array") {
						$data[$key] = $_POST[$key];
					}else {
						$data[$key] = Input::get($key);
					}			
				}
				$data['password'] = "studentPass";
				$username = $data['fname'].$data['lname'].$data['programId'].$data['sectionId'].preg_replace("/[^0-9]/", "", $data['dobAd']);
				$dataToSearch = array("username" => $username);
				$userdata3 = $this->model->searchData("userlogin", $dataToSearch);
				$cnn = 0;
				$userdata = array();
				for ($i = 0; $i < count($userdata3); $i++) { 
					if($userdata3[$i]['id'] != $idToUpdate)
						$userdata[$cnn++] = $userdata3[$i];
				}
				$updates = array();
				if(count($userdata) == 0 ) {
					$toRegister = array(
						"username" => $username,
						"fname" => $data['fname'],
						"mname" => $data['mname'],
						"lname" => $data['lname'],
						"email" => $data['email'],
						"passwordHash" => md5($data['password']),
						"role" => "3" // for student
					);
					$output = $this->model->updateData("userlogin", $idToUpdate, $toRegister);
					array_push($updates, $output);
					$pk = $this->model->getDataId("personaldata",array('userId' => $idToUpdate));
					$toRegister = array(
						"userId" => $idToUpdate,
						"password" => $data['password'],
						"programId" => $data['programId'],
						"yearOrSemester" => $data['yearOrSemester'],
						"sectionId" => $data['sectionId'],
						"dobAd" => $data['dobAd'],
						"gender" => $data['gender'],
						"nationality" => $data['nationality'],
						"fatherName" => $data['fatherName'],
						"rollNo" => $data['rollNo'],
						"status" => $data['status']
					);
					$output = $this->model->updateData("personaldata", $pk, $toRegister);
					array_push($updates, $output);	
					$pk = $this->model->getDataId("contactdetails",array('userId' => $idToUpdate));
					$toRegister = array(
						"userId" => $idToUpdate,
						"municipality" => $data['municipality'],
						"area" => $data['area'],
						"district" => $data['district'],
						"wardNo" => $data['wardNo'],
						"province" => $data['province'],
						"mobileNo" => $data['mobileNo'],
						"telephoneNo" => $data['telephoneNo'],
						"guardianName" => $data['guardianName'],
						"guardianRelation" => $data['guardianRelation'],
						"guardianContact" => $data['guardianContact']
					);
					$output = $this->model->updateData("contactdetails", $pk, $toRegister);
					array_push($updates, $output);			
					$pk = $this->model->getDataId("education",array('userId' => $idToUpdate));
					$toRegister = array(
						"userId" => $idToUpdate,
						"level" => $data['level'],
						"symbolNo" => $data['symbolNo'],
						"institution" => $data['institution'],
						"board" => $data['board'],
						"yearOfCompletion" => $data['yearOfCompletion'],
						"percent" => $data['percent']
					);
					$output = $this->model->updateData("education", $pk, $toRegister);
					array_push($updates, $output);
					$isChanged = in_array(1, $updates);				
					if($isChanged) {
						$result['status'] = 1;
						$result['success'] = true;
					}else {
						$result['status'] = 0;
						$validate->addError("Nothing changes!");
					}						
				}else {
					$validate->addError("Student already registered!");
					$result['status'] = 0;				
				}
			}else {
				$result['status'] = 0;
				$validate->addError("No such Student found!");
			}			
		} else {
			$result['status'] = 0;
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			if(count($validate->errors()) >= 5){
				$result['errors'] = array("Field(*) are required.");
			}else{
				$result['errors'] = $validate->errors();
			}
			$result['success'] = false;
		} 
		unset($_POST);
		return print json_encode($result);	
	}

	private function addStudent($result){
		$validate = new Validator();
		$validation = $validate->check($_POST, $this->getValidators());
		if($validate->passed()){
			$data = array();
			$data['id'] = null;
			foreach ($_POST as $key => $value) {
				if(gettype($value) == "boolean" || gettype($value) == "array") {
					$data[$key] = $_POST[$key];
				}else {
					$data[$key] = Input::get($key);
				}			
			}
			$data['password'] = "studentPass";
			$username = $data['fname'].$data['lname'].$data['programId'].$data['sectionId'].preg_replace("/[^0-9]/", "", $data['dobAd']);
			$dataToSearch = array("username" => $username);
			$userdata = $this->model->searchData("userlogin", $dataToSearch);
			if(count($userdata) <= 0) {
				$toRegister = array(
					"username" => $username,
					"fname" => $data['fname'],
					"mname" => $data['mname'],
					"lname" => $data['lname'],
					"email" => $data['email'],
					"passwordHash" => md5($data['password']),
					"role" => "3" // for student
				);
				$userId = $this->model->registerData("userlogin", $toRegister);
				if($userId != 0) {
					$toRegister = array(
						"userId" => $userId,
						"password" => $data['password'],
						"programId" => $data['programId'],
						"yearOrSemester" => $data['yearOrSemester'],
						"sectionId" => $data['sectionId'],
						"dobAd" => $data['dobAd'],
						"gender" => $data['gender'],
						"nationality" => $data['nationality'],
						"fatherName" => $data['fatherName'],
						"rollNo" => $data['rollNo'],
						"status" => $data['status']
					);
					$personalId = $this->model->registerData("personaldata", $toRegister);
						if($personalId != 0) {
							$toRegister = array(
								"userId" => $userId,
								"municipality" => $data['municipality'],
								"area" => $data['area'],
								"district" => $data['district'],
								"wardNo" => $data['wardNo'],
								"province" => $data['province'],
								"mobileNo" => $data['mobileNo'],
								"telephoneNo" => $data['telephoneNo'],
								"guardianName" => $data['guardianName'],
								"guardianRelation" => $data['guardianRelation'],
								"guardianContact" => $data['guardianContact']
							);
							$contactId = $this->model->registerData("contactdetails", $toRegister);
							if($contactId != 0) {
								$toRegister = array(
									"userId" => $userId,
									"level" => $data['level'],
									"symbolNo" => $data['symbolNo'],
									"institution" => $data['institution'],
									"board" => $data['board'],
									"yearOfCompletion" => $data['yearOfCompletion'],
									"percent" => $data['percent']
								);
								$educationId = $this->model->registerData("education", $toRegister);
								if($educationId != 0) {
									$result['status'] = 1;
									$result['success'] = true;
								}else {
									$this->model->deleteData("userlogin", $userId);
									$this->model->deleteData("personaldata", $personalId);
									$this->model->deleteData("contactdetails", $contactId);
									$result['status'] = 0;
									$validate->addError("Can't add to education table.");
								}
							} else {
								$this->model->deleteData("userlogin", $userId);
								$this->model->deleteData("personaldata", $personalId);
								$result['status'] = 0;
								$validate->addError("Can't add to contact table.");
							}
						}else {
							$this->model->deleteData("userlogin", $userId);
							$result['status'] = 0;
							$validate->addError("Can't add to personaldata table.");
						}
				}else {
					$result['status'] = 0;
					$validate->addError("Can't add to login table.");
				}
			}else {
				$validate->addError("Student already registered!");
				$result['status'] = 0;				
			}
			
		} else {
			$result['status'] = 0;
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			$result['success'] = false;
			if(count($validate->errors()) >= 5){
				$result['errors'] = array("Field(*) are required.");
			}else{
				$result['errors'] = $validate->errors();
			}
		} 
		unset($_POST);
		return print json_encode($result);	
	}


	private function getValidators() {
		if(Session::isLoggedIn(1))
			return array(
				'fname' => array(
					'name' => 'First Name',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'lname' => array(
					'name' => 'Last Name',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'programId' => array(
					//"userDefinedError" => "Program is not valid.",
					'name' => 'Program',
					'required' => true,
					'minLevel' => 1
				),
				'yearOrSemester' => array(
					//"userDefinedError" => "Year/Semester is not valid.",
					'name' => 'Year/Semester',
					'required' => true,
					'minLevel' => 1
				),
				'sectionId' => array(
					//"userDefinedError" => "Section is not valid.",
					'name' => 'Section',
					'required' => true,
					'minLevel' => 1
				),
				'dobAd' => array(
					'name' => 'Date of Birth(A.D)',
					'required' => true
				),
				'rollNo' => array(
					'name' => 'Roll No',
					'min' => 1,
					'required' => true
				),
				'gender' => array(
					//"userDefinedError" => "Gender is not valid.",
					'name' => 'Gender',
					'required' => true,
					'minLevel' => 1,
					'maxLevel' => 4
				),
				'municipality' => array(
					'name' => 'Municipality',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'wardNo' => array(
					'name' => 'Ward Number',
					'required' => true,
					'minLevel' => 1,
					'maxLevel' => 1000
				),
				'area' => array(
					'name' => 'Area',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'district' => array(
					'name' => 'District',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'province' => array(
					'name' => 'province',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'mobileNo' => array(
					'name' => 'Mobile No.',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'email' => array(
					'name' => 'Email',
					'type' => 'email'
				),
				'level' => array(
					//"userDefinedError" => "Education Level is not valid.",
					'name' => 'Education Level',
					'required' => true,
					'minLevel' => 1
				),
				'board' => array(
					'name' => 'Education Board',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'symbolNo' => array(
					'name' => 'Symbol No',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'percent' => array(
					'name' => 'Percent/Grade',
					'required' => true,
					'max' => 255
				),
				'institution' => array(
					'name' => 'Education institution',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'yearOfCompletion' => array(
					'name' => "Year of Completion",
					'required' => true,
				)
			);
	}


}

?>