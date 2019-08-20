<?php

class Student extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		header("Location: ".SITE_URL."/student/all");
	}

	public function all($name = "") {
		$this->model->setTable('userlogin');
		if(($name == "export" || $name == "add" || $name == "update" || $name == "delete" || $name == "get") && Session::isLoggedIn(1)) {
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
				if($name == "export") {
					return $this->exportStudent($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}		

		} else if($name == ''){	
			if(Session::isLoggedIn(1)) {
				$this->model->setTable('program');
				$all = $this->model->getAllStudent();
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

    private function getStudent($result) {
		$startIndex = $_POST['start'];
		$totalCount = $_POST['length'];
		$startIndex = ($totalCount == -1) ? 0 : $startIndex;
		$columnToSort = null;
		$sortDir = null;
		$stringToSearch = null;
		$fieldToSearch = array("fname","username","email","lname");
		/*if(isset($_POST["order"][0]["column"])){
			$sortDir = Sanitize::escape($_POST["order"][0]["dir"]);

			$columnToSort = $_POST["order"][0]["column"];

			$columnToSort = (!isset($_POST["columns"][$columnToSort]["name"]) && $_POST["columns"][$columnToSort]["orderable"]) ? $_POST["columns"][$columnToSort]["name"] : "fname" ;
			$columnToSort = Sanitize::escape($columnToSort);
		}*/
		if(isset($_POST["search"]["value"])) {
			$stringToSearch = Sanitize::escape($_POST["search"]["value"]);
		}
		$this->model->setTable('userlogin');
		$result2 = $this->model->getAllStudentConditions($stringToSearch,$fieldToSearch,$columnToSort,$sortDir);
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

		if(isset($_POST['filterData']) && $_POST['filterData'] > 0) {
			$i = 0;
			foreach ($res as $value) {
				if($value['programId'] != $_POST['filterData']) {
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
			unset($arr[$index]['role']);

			if(count($arr[$index]['edu']) > 0) {
				$co = 0;
				foreach ($arr[$index]['edu'] as $value) {
					switch ($arr[$index]['edu'][$co]['level']) {
						case 1:
							$arr[$index]['edu'][$co]['levelName'] = "SLC";
							break;
						case 2:
							$arr[$index]['edu'][$co]['levelName'] = "+2";
							break;
						case 3:
							$arr[$index]['edu'][$co]['levelName'] = "Intermediate";
							break;
						default:
							$arr[$index]['edu'][$co]['levelName'] = "HA";					
					}
					$co++;
				}
			}			
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
			$this->setForeignModel("QuestionModel");
			$this->foreignModel->setTable("program");
			$programs = $this->foreignModel->searchQuestion($toSearch);
			if(count($programs) > 0) {
				$arr[$index]['programName'] = $programs[0]['name'];
			}
			$index++;
		}

		$name  = array_column($arr, 'name');
		$username = array_column($arr, 'username');
		$toSort = (isset($_POST["order"][0]["column"])) ? $_POST["columns"][$_POST["order"][0]["column"]]["data"] : $name;
		if(isset($_POST["order"][0]["dir"]) && ($toSort == "name" || $toSort == "username")) {
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
		$result['recordsTotal'] = $total;
		$result['recordsFiltered'] = $total;
		unset($_POST);
		return print json_encode($result);
	}

	private function getAllStudentRecords($idArray){
		$total = array();
		$tableName = array("personaldata", "documents","contactdetails");
		foreach ($idArray as $id) {
			$one = array();
			$res = $this->searchDataFromTable("userlogin", array("id" => $id));
			if(count($res) > 0) {
				foreach ($res[0] as $key => $value) {
					$one[$key] = $value;
				}
			}
			foreach ($tableName as $table) {
				$result = $this->searchDataFromTable($table, array("userId" => $id));
				if(count($result) > 0) {
					foreach ($result[0] as $key => $value) {
						$one[$key] = $value;
					}
				}				
			}
			$res = $this->searchDataFromTable("education", array("userId" => $id));
			$one["edu"] = $res;
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
			$res = $this->model->searchStudent($dataToSearch);
			if(count($res) >= 1) {
				$out = $this->deleteDataFromTable("userlogin", $idToDel);
				$pk = $this->getPKFromTable("personaldata",array('userId' => $idToDel));
				if($pk != 0) $this->deleteDataFromTable("personaldata", $pk);
				$pk = $this->getPKFromTable("documents",array('userId' => $idToDel));
				if($pk != 0) $this->deleteDataFromTable("documents", $pk);
				$pk = $this->getPKFromTable("contactdetails",array('userId' => $idToDel));
				if($pk != 0) $this->deleteDataFromTable("contactdetails", $pk);
				$pk = $this->getPKFromTable("education",array('userId' => $idToDel));
				do {
					if($pk != 0) $this->deleteDataFromTable("education", $pk);
					$pk = $this->getPKFromTable("education",array('userId' => $idToDel));
				}while($pk != 0);
				$pk = $this->getPKFromTable("timetrack",array('userId' => $idToDel));
				do {
					if($pk != 0) $this->deleteDataFromTable("timetrack", $pk);
					$pk = $this->getPKFromTable("timetrack",array('userId' => $idToDel));
				}while($pk != 0);
				$pk = $this->getPKFromTable("record",array('userId' => $idToDel));
				do {
					if($pk != 0) $this->deleteDataFromTable("record", $pk);
					$pk = $this->getPKFromTable("record",array('userId' => $idToDel));
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
		$validation = $validate->check($_POST, array());
		if($validate->passed()){
			$dataForSearch = array('id' => $_POST['id']);
			$res = $this->model->searchStudent($dataForSearch);
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
				$data['password'] = "eversoft".strtolower(trim(str_replace(' ', '', Input::get('entranceNo'))));
				$username = strtolower(trim(str_replace(' ', '', Input::get('fname')))) . 
							strtolower(trim(str_replace(' ', '', Input::get('entranceNo'))));
				$dataToSearch = array("username" => $username);
				$isEmailRegistered = array();
				$userdata3 = $this->searchDataFromTable("userlogin", $dataToSearch);
				$cnn = 0;
				$userdata = array();
				$isEmailRegistered = array();
				for ($i = 0; $i < count($userdata3); $i++) { 
					if($userdata3[$i]['id'] != $idToUpdate)
						$userdata[$cnn++] = $userdata3[$i];
				}	
				if(isset($data['email']) && !empty($data['email'])) {
					$dataToSearch = array("email" => $data['email']);
					$isEmailRegistered3 = $this->searchDataFromTable("userlogin", $dataToSearch);
					$cnn = 0;
					for ($i = 0; $i < count($isEmailRegistered3); $i++) { 
						if($isEmailRegistered3[$i]['id'] != $idToUpdate)
							$isEmailRegistered[$cnn++] = $isEmailRegistered3[$i];
					}
				}
				$updates = array();
				if(count($userdata) == 0 && count($isEmailRegistered) == 0) {
					$toRegister = array(
						"username" => $username,
						"fname" => $data['fname'],
						"mname" => $data['mname'],
						"lname" => $data['lname'],
						"email" => $data['email'],
						"passwordHash" => md5($data['password']),
						"role" => "3" // for student
					);
					$output = $this->updateDataToTable("userlogin", $idToUpdate, $toRegister);
					array_push($updates, $output);
					$pk = $this->getPKFromTable("personaldata",array('userId' => $idToUpdate));
					$toRegister = array(
						"userId" => $idToUpdate,
						"password" => $data['password'],
						"programId" => $data['programId'],
						"doa" => $data['doa'],
						"dobAd" => $data['dobAd'],
						"dobBs" => $data['dobAd'], // temporary no change
						"gender" => $data['gender'],
						"nationality" => $data['nationality'],
						"fatherName" => $data['fatherName']
					);
					$output = $this->updateDataToTable("personaldata", $pk, $toRegister);
					array_push($updates, $output);	
					$pk = $this->getPKFromTable("contactdetails",array('userId' => $idToUpdate));
					$toRegister = array(
						"userId" => $idToUpdate,
						"municipality" => $data['municipality'],
						"area" => $data['area'],
						"district" => $data['district'],
						"wardNo" => $data['wardNo'],
						"zone" => $data['zone'],
						"mobileNo" => $data['mobileNo'],
						"telephoneNo" => $data['telephoneNo'],
						"blockNo" => $data['blockNo'],
						"guardianName" => $data['guardianName'],
						"guardianRelation" => $data['guardianRelation'],
						"guardianContact" => $data['guardianContact']
					);
					$output = $this->updateDataToTable("contactdetails", $pk, $toRegister);
					array_push($updates, $output);			
					$pk = $this->getPKFromTable("documents",array('userId' => $idToUpdate));
					$toRegister = array(
						"userId" => $idToUpdate,
						"formNo" => $data['formNo'],
						"entranceNo" => $data['entranceNo'],
						"eligible" => $data['eligible'],
						"remarks" => $data['remarks'],
						"marksheet_see" => $data['marksheet_see'],
						"marksheet_11" => $data['marksheet_11'],
						"marksheet_12" => $data['marksheet_12'],
						"transcript" => $data['transcript'],
						"characterCertificate_see" => $data['characterCertificate_see'],
						"characterCertificate_12" => $data['characterCertificate_12'],
						"citizenship" => $data['citizenship'],
						"photo" => $data['photo']
					);
					$output = $this->updateDataToTable("documents", $pk, $toRegister);
					array_push($updates, $output);
					$isChanged = in_array(1, $updates);				
					$pk = $this->getPKFromTable("education",array('userId' => $idToUpdate));
					do {
						if($pk != 0) $this->deleteDataFromTable("education", $pk);
						$pk = $this->getPKFromTable("education",array('userId' => $idToUpdate));
					}while($pk != 0);
					$registeredId = array();
					if(isset($_POST['edu'])) {
						$count = count($_POST['edu']);
						foreach ($_POST['edu'] as $value) {
							$toRegister = array(
								"userId" => $idToUpdate,
								"level" => Sanitize::escape(trim($value['level'], " ")),
								"faculty" => Sanitize::escape(trim($value['faculty'], " ")),
								"institution" => Sanitize::escape(trim($value['institution'], " ")),
								"board" => Sanitize::escape(trim($value['board'], " ")),
								"yearOfCompletion" => Sanitize::escape(trim($value['yearOfCompletion'], " ")),
								"percent" => Sanitize::escape(trim($value['percent'], " "))
							);
							$educationId = $this->setDataToTable("education", $toRegister);
							if($educationId != 0) array_push($registeredId, $educationId);				
						}
						if($count == count($registeredId) || isChanged) {
							$isChanged = true;
						}
					}
					if($isChanged) {
						$result['status'] = 1;
						$result['success'] = true;
					}else {
						$result['status'] = 0;
						$validate->addError("Nothing changes!");
					}						
				}else {
					if(count($userdata) != 0){
						$validate->addError("User already registered!");
					}
					if(count($isEmailRegistered) != 0) {
						$validate->addError("Email already registered!");
					}
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
			$result['errors'] = $validate->errors();
			$result['success'] = false;
		} 
		unset($_POST);
		return print json_encode($result);	
	}

	private function addStudent($result){
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
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
				'name' => 'Program',
				'required' => true,
				'minLevel' => 1
			),
			'doa' => array(
				'name' => 'Date of Application',
				'required' => true
			),
			'dobAd' => array(
				'name' => 'Date of Birth(A.D)',
				'required' => true
			),
			'gender' => array(
				'name' => 'Gender',
				'required' => true,
				'minLevel' => 1,
				'maxLevel' => 4
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
			'zone' => array(
				'name' => 'Zone',
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
				'required' => true,
				'type' => 'email'
			),
			'formNo' => array(
				'name' => 'Form No.',
				'required' => true,
				'min' => 1,
				'max' => 255
			),
			'entranceNo' => array(
				'name' => 'Registration No.',
				'required' => true,
				'min' => 1,
				'max' => 255
			)
		));
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
			$data['password'] = "eversoft".strtolower(trim(str_replace(' ', '', Input::get('entranceNo'))));
			$username = strtolower(trim(str_replace(' ', '', Input::get('fname')))) . 
						strtolower(trim(str_replace(' ', '', Input::get('entranceNo'))));
			$dataToSearch = array("username" => $username);
			$isEmailRegistered = array();
			$userdata = $this->searchDataFromTable("userlogin", $dataToSearch);
			if(isset($data['email']) && !empty($data['email'])) {
				$dataToSearch = array("email" => $data['email']);
				$isEmailRegistered = $this->searchDataFromTable("userlogin", $dataToSearch);
			}
			if(count($userdata) == 0 && count($isEmailRegistered) == 0) {
				$toRegister = array(
					"username" => $username,
					"fname" => $data['fname'],
					"mname" => $data['mname'],
					"lname" => $data['lname'],
					"email" => $data['email'],
					"passwordHash" => md5($data['password']),
					"role" => "3" // for student
				);
				$userId = $this->setDataToTable("userlogin", $toRegister);
				if($userId != 0) {
					$toRegister = array(
						"userId" => $userId,
						"password" => $data['password'],
						"programId" => $data['programId'],
						"doa" => $data['doa'],
						"dobAd" => $data['dobAd'],
						"dobBs" => $data['dobAd'], // temporary no change
						"gender" => $data['gender'],
						"nationality" => $data['nationality'],
						"fatherName" => $data['fatherName']
					);
					$personalId = $this->setDataToTable("personaldata", $toRegister);
						if($personalId != 0) {
							$toRegister = array(
								"userId" => $userId,
								"municipality" => $data['municipality'],
								"area" => $data['area'],
								"district" => $data['district'],
								"wardNo" => $data['wardNo'],
								"zone" => $data['zone'],
								"mobileNo" => $data['mobileNo'],
								"telephoneNo" => $data['telephoneNo'],
								"blockNo" => $data['blockNo'],
								"guardianName" => $data['guardianName'],
								"guardianRelation" => $data['guardianRelation'],
								"guardianContact" => $data['guardianContact']
							);
							$contactId = $this->setDataToTable("contactdetails", $toRegister);
							if($contactId != 0) {
								$toRegister = array(
									"userId" => $userId,
									"formNo" => $data['formNo'],
									"entranceNo" => $data['entranceNo'],
									"eligible" => $data['eligible'],
									"remarks" => $data['remarks'],
									"marksheet_see" => $data['marksheet_see'],
									"marksheet_11" => $data['marksheet_11'],
									"marksheet_12" => $data['marksheet_12'],
									"transcript" => $data['transcript'],
									"characterCertificate_see" => $data['characterCertificate_see'],
									"characterCertificate_12" => $data['characterCertificate_12'],
									"citizenship" => $data['citizenship'],
									"photo" => $data['photo']
								);
								$documentId = $this->setDataToTable("documents", $toRegister);
								if($documentId != 0) {
									$registeredId = array();
									if(isset($_POST['edu'])) {
										$count = count($_POST['edu']);
										foreach ($_POST['edu'] as $value) {
											$toRegister = array(
												"userId" => $userId,
												"level" => Sanitize::escape(trim($value['level'], " ")),
												"faculty" => Sanitize::escape(trim($value['faculty'], " ")),
												"institution" => Sanitize::escape(trim($value['institution'], " ")),
												"board" => Sanitize::escape(trim($value['board'], " ")),
												"yearOfCompletion" => Sanitize::escape(trim($value['yearOfCompletion'], " ")),
												"percent" => Sanitize::escape(trim($value['percent'], " "))
											);
											$educationId = $this->setDataToTable("education", $toRegister);
											if($educationId != 0) array_push($registeredId, $educationId);				
										}
										if($count == count($registeredId)) {
											$result['status'] = 1;
											$result['success'] = true;
										} else {
											foreach ($registeredId as $value) {
												$this->deleteDataFromTable("education", $value);
											}
											$this->deleteDataFromTable("userlogin", $userId);
											$this->deleteDataFromTable("personaldata", $personalId);
											$this->deleteDataFromTable("contactdetails", $contactId);
											$this->deleteDataFromTable("documents", $documentId);
											$result['status'] = 0;
											$validate->addError("Can't add to education table.");		
										}
										
									}
								}else {
									$this->deleteDataFromTable("userlogin", $userId);
									$this->deleteDataFromTable("personaldata", $personalId);
									$this->deleteDataFromTable("contactdetails", $contactId);
									$result['status'] = 0;
									$validate->addError("Can't add to document table.");
								}
							} else {
								$this->deleteDataFromTable("userlogin", $userId);
								$this->deleteDataFromTable("personaldata", $personalId);
								$result['status'] = 0;
								$validate->addError("Can't add to contact table.");
							}
						}else {
							$this->deleteDataFromTable("userlogin", $userId);
							$result['status'] = 0;
							$validate->addError("Can't add to personaldata table.");
						}
				}else {
					$result['status'] = 0;
					$validate->addError("Can't add to login table.");
				}
			}else {
				if(count($userdata) != 0){
					$validate->addError("User already registered!");
				}
				if(count($isEmailRegistered) != 0) {
					$validate->addError("Email already registered!");
				}
				$result['status'] = 0;				
			}
			
		} else {
			$result['status'] = 0;
			if(count($validate->errors()) >= 5){
				$result['errors'] = array("Field(*) are required.");
			}else{
				$result['errors'] = $validate->errors();
			}
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			$result['success'] = false;
		} 
		unset($_POST);
		return print json_encode($result);	
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

	private function exportStudent($result) {
		var_dump($this->model->searchStudent(array("role" => 3)));
	}
}

?>