<?php

class Manage extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		header("Location: ".SITE_URL."/manage/program");
	}

	public function program($name='') {
    	$this->model->setTable('program');
		if(($name == "add" || $name == "update" || $name == "delete" || $name == "get") && (Session::isLoggedIn(1))) {
			$result = array('status' => 0);	
			if(isset($_POST) && count($_POST) > 0) {
				if($name == "get") {
					return $this->getProgram($result);
				}
				if($name == "delete" && isset($_POST['id'])) {
					return $this->deleteProgram($result);
				}
				if($name == "update" && isset($_POST['id'])) {
					return $this->updateProgram($result);
				}
				if($name == "add") {
					return $this->addProgram($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}
		} else if($name == ''){	
			if(Session::isLoggedIn(1)) {
				$this->model->template = VIEWS_DIR.DS."manage".DS."program.php";
				$this->view->render();
			}else {
				header("Location: ".SITE_URL."/home/dashboard");
			}			
		} else {
			header("Location: ".SITE_URL."/home/message");
		}
		
	}

	public function subject($name = '') {

		$this->model->setTable('subject');
		if(($name == "add" || $name == "update" || $name == "delete" || $name == "get") && (Session::isLoggedIn(1))) {
			$result = array('status' => 0);	
			if(isset($_POST) && count($_POST) > 0) {
				if($name == "get") {
					return $this->getSubject($result);
				}
				if($name == "delete" && isset($_POST['id'])) {
					return $this->deleteSubject($result);
				}
				if($name == "update" && isset($_POST['id'])) {
					return $this->updateSubject($result);
				}
				if($name == "add") {
					return $this->addSubject($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}
		} else if($name == ''){	
			if(Session::isLoggedIn(1)) {
				$all = $this->model->getAllData('program');
				$this->model->data['program'] = $all;
				$finalArray = $this->model->getAllData("userlogin");
				$res = array();
				$countA = 0;
				if($finalArray > 0) {
					foreach ($finalArray as $value) {					
						if(!($value['role'] == 3)) {
							$res[$countA]['name'] = $value['fname']." ".$value['mname']." ".$value['lname'];
							$res[$countA]['userId'] = $value['id'];
							$countA++;
						}
					}
				}
				$this->model->data["teachers"] = $res;
				$this->model->template = VIEWS_DIR.DS."manage".DS."subject.php";
				$this->view->render();
			}else {
				header("Location: ".SITE_URL."/home/dashboard");
			}			
		} else {
			header("Location: ".SITE_URL."/home/message");
		}
	}

	public function section($name='') {
    	$this->model->setTable('section');
		if(($name == "add" || $name == "update" || $name == "delete" || $name == "get") && (Session::isLoggedIn(1))) {
			$result = array('status' => 0);	
			if(isset($_POST) && count($_POST) > 0) {
				if($name == "get") {
					return $this->getSection($result);
				}
				if($name == "delete" && isset($_POST['id'])) {
					return $this->deleteSection($result);
				}
				if($name == "update" && isset($_POST['id'])) {
					return $this->updateSection($result);
				}
				if($name == "add") {
					return $this->addSection($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}
		} else if($name == ''){	
			if(Session::isLoggedIn(1)) {
				$all = $this->model->getAllData('program');
				$this->model->data['program'] = $all;
				$this->model->template = VIEWS_DIR.DS."manage".DS."section.php";
				$this->view->render();
			}else {
				header("Location: ".SITE_URL."/home/dashboard");
			}			
		} else {
			header("Location: ".SITE_URL."/home/message");
		}
		
	}


	private function getProgram($result) {
		$startIndex = $_POST['start'];
		$totalCount = $_POST['length'];
		$startIndex = ($totalCount == -1) ? 0 : $startIndex;
		$columnToSort = null;
		$sortDir = null;
		$stringToSearch = null;
		$fieldToSearch = array("name","details");
		if(isset($_POST["order"][0]["column"])){
			$sortDir = Sanitize::escape($_POST["order"][0]["dir"]);

			$columnToSort = $_POST["order"][0]["column"];

			$columnToSort = (isset($_POST["columns"][$columnToSort]["data"]) && ($_POST["columns"][$columnToSort]["orderable"]) == "true") ? $_POST["columns"][$columnToSort]["data"] : "name" ;
			$columnToSort = Sanitize::escape($columnToSort);
		}
		if(isset($_POST["search"]["value"])) {
			$stringToSearch = Sanitize::escape($_POST["search"]["value"]);
		}
		$res = $this->model->getAllDataConditions("program",$stringToSearch,$fieldToSearch,$columnToSort,$sortDir);
		$total = count($res);
		$index = 0;
		$arr = array();
		$totalCount = ($totalCount == -1) ? $total : $totalCount;
		for ($i = $startIndex; $i < $startIndex + $totalCount && $i < $total; $i++){
			$arr[$index] = $res[$i];
			$index++;
		}

		if(count($arr) >= 1){
			$result['status'] = 1;
		}
		$result['data'] = $arr;
		$result['success'] = ($result['status'] == 1) ? true : false;
		$result['draw'] = $_POST['draw'];
		$result['recordsTotal'] = $total;
		$result['recordsFiltered'] = $index;
		unset($_POST);
		return print json_encode($result);
	}

	private function deleteProgram($result) {
		if(!isset($_POST['id'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$idToDel = Input::get('id');
			$dataToSearch = array('id' => $idToDel);
			$res = $this->model->getData('program',$dataToSearch);
			if($res != null) {
				$deleted = $this->model->deleteData('program', $idToDel);
				if($deleted >= 1) {
					$result['status'] = 1;
				}else {
					$result['status'] = -1;
				}
			}else {
				$result['error'] = array("No such program found.");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
	}

	private function updateProgram($result) {
		$data = array();
		foreach ($_POST as $key => $value) {
			$data[$key] = Input::get($key);
		}
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'name' => 'Name',
				'required' => true,
				'min' => 1,
				'max' => 255
			),
			'details' => array(
				'name' => 'Detail',
				'min' => 1,
				'max' => 1200
			),
			'noOfYearOrSemester' => array(
				'name' => 'Number of Years or Semesters',
				'required' => true,
				'minLevel' => 1,
				'maxLevel' => 20
			)
		));
		if(Input::get('yearOrSemester') != 0 &&  Input::get('yearOrSemester') != 1) $validate->addError("Years Or Semester isnot selected!");
		if($validate->passed()){
			$dataForSearch = array('id' => $data['id']);
			$res = $this->model->searchData('program',$dataForSearch);
			if(count($res) >= 1) {
				$idToChange = $data['id'];
				unset($data['id']);
				$ret = $this->model->updateData('program', $idToChange, $data);
				if($ret == 1) {
					$result['status'] = 1;
					$result['success'] = true;
				} else {
					$result['status'] = -1;
					$result['errors'] = $validate->addError("Nothing updated!");
				}							
			} else {
				$result['errors'] = $validate->addError("No such program found.");
				$result['status'] = 0;
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

	private function addProgram($result){
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'name' => 'Name',
				'required' => true,
				'min' => 1,
				'max' => 255
			),
			'details' => array(
				'name' => 'Detail',
				'min' => 1,
				'max' => 1200
			),
			'noOfYearOrSemester' => array(
				'name' => 'Number of Years or Semesters',
				'required' => true,
				'minLevel' => 1,
				'maxLevel' => 20
			)
		));
		if(Input::get('yearOrSemester') != 0 &&  Input::get('yearOrSemester') != 1) $validate->addError("Years Or Semester isnot selected!");
		if($validate->passed()){
			$data = array();
			$data['id'] = null;
			foreach ($_POST as $key => $value) {
				$data[$key] = Input::get($key);
			}
			$searchForProgram = $this->model->getData('program',array(
				'name' => $data['name'],
				//'programId' => $data['programId'],
				'noOfYearOrSemester' => $data['noOfYearOrSemester']
			));
			if($searchForProgram == null) {
				$id = $this->model->registerData('program', $data);
				if($id != 0){
					$result['status'] = 1;
					$result['success'] = true;
				}else{
					$result['status'] = -1;
					$result['errors'] = $validate->addError("Problem with connection to server!");
				}
			} else {
				$result['status'] = 0;
				$validate->addError("Program already registered !");
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

	private function getSection($result) {
		$startIndex = $_POST['start'];
		$totalCount = $_POST['length'];
		$startIndex = ($totalCount == -1) ? 0 : $startIndex;
		$columnToSort = null;
		$sortDir = null;
		$stringToSearch = null;
		$fieldToSearch = array("name","details");
		if(isset($_POST["order"][0]["column"])){
			$sortDir = Sanitize::escape($_POST["order"][0]["dir"]);

			$columnToSort = $_POST["order"][0]["column"];

			$columnToSort = (isset($_POST["columns"][$columnToSort]["data"]) && ($_POST["columns"][$columnToSort]["orderable"]) == "true") ? $_POST["columns"][$columnToSort]["data"] : "name" ;
			$columnToSort = Sanitize::escape($columnToSort);
		}
		if(isset($_POST["search"]["value"])) {
			$stringToSearch = Sanitize::escape($_POST["search"]["value"]);
		}
		$res = $this->model->getAllDataConditions("section",$stringToSearch,$fieldToSearch,$columnToSort,$sortDir);
		$totalWithoutCount = count($res);
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

		$total = count($res);
		$index = 0;
		$arr = array();
		$totalCount = ($totalCount == -1) ? $total : $totalCount;
		for ($i = $startIndex; $i < $startIndex + $totalCount && $i < $total; $i++){
			$arr[$index] = $res[$i];			
			$row = $this->model->getData('program', array('id' => $arr[$index]['programId']));
			$arr[$index]['programName'] = ($row != null) ? $row['name'] : "undefined";
			$index++;
		}

		if(count($arr) >= 1){
			$result['status'] = 1;
		}
		$result['data'] = $arr;
		$result['success'] = ($result['status'] == 1) ? true : false;
		$result['draw'] = $_POST['draw'];
		$result['recordsTotal'] = $totalWithoutCount;
		$result['recordsFiltered'] = $index;
		unset($_POST);
		return print json_encode($result);
	}

	private function deleteSection($result) {
		if(!isset($_POST['id'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$idToDel = Input::get('id');
			$dataToSearch = array('id' => $idToDel);
			$res = $this->model->getData('section',$dataToSearch);
			if($res != null) {
				$deleted = $this->model->deleteData('section', $idToDel);
				if($deleted >= 1) {
					$result['status'] = 1;
				}else {
					$result['status'] = -1;
				}
			}else {
				$result['error'] = array("No such section found.");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
	}

	private function updateSection($result) {
		$data = array();
		foreach ($_POST as $key => $value) {
			$data[$key] = Input::get($key);
		}
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'name' => 'Name',
				'required' => true,
				'min' => 1,
				'max' => 255
			),
			'programId' => array(
				//"userDefinedError" => "Program is not valid.",
				'name' => 'Program Id',
				'required' => true,
				'minLevel' => 1
			),
			'yearOrSemester' => array(
				//"userDefinedError" => "Year/Semester is not valid.",
				'name' => 'Year / Semester',
				'required' => true,
				'minLevel' => 1,
				'maxLevel' => 20
			),
			'details' => array(
				'name' => 'Details',
				'min' => 1,
				'max' => 255
			)
		));
		if($validate->passed()){
			$dataForSearch = array('id' => $data['id']);
			$res = $this->model->searchData('section',$dataForSearch);
			if(count($res) >= 1) {
				$idToChange = $data['id'];
				unset($data['id']);
				$ret = $this->model->updateData('section', $idToChange, $data);
				if($ret == 1) {
					$result['status'] = 1;
					$result['success'] = true;
				} else {
					$result['status'] = -1;
					$result['errors'] = $validate->addError("Nothing updated!");
				}							
			} else {
				$result['errors'] = $validate->addError("No such section found.");
				$result['status'] = 0;
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

	private function addSection($result){
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'name' => 'Name',
				'required' => true,
				'min' => 1,
				'max' => 255
			),
			'programId' => array(
				//"userDefinedError" => "Program is not valid.",
				'name' => 'Program Id',
				'required' => true,
				'minLevel' => 1
			),
			'yearOrSemester' => array(
				//"userDefinedError" => "Year/Semester is not valid.",
				'name' => 'Year / Semester',
				'required' => true,
				'minLevel' => 1,
				'maxLevel' => 20
			),
			'details' => array(
				'name' => 'Details',
				'min' => 1,
				'max' => 255
			)
		));
		if($validate->passed()){
			$data = array();
			$data['id'] = null;
			foreach ($_POST as $key => $value) {
				$data[$key] = Input::get($key);
			}
			$searchForSection = $this->model->getData('section',array(
				'name' => $data['name'],
				'programId' => $data['programId'],
				'yearOrSemester' => $data['yearOrSemester']
			));
			if($searchForSection == null) {
				$id = $this->model->registerData('section', $data);
				if($id != 0){
					$result['status'] = 1;
					$result['success'] = true;
				}else{
					$result['status'] = -1;
					$result['errors'] = $validate->addError("Problem with connection to server!");
				}
			} else {
				$result['status'] = 0;
				$validate->addError("Section already registered !");
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


	private function getSubject($result) {
		$startIndex = $_POST['start'];
		$totalCount = $_POST['length'];
		$startIndex = ($totalCount == -1) ? 0 : $startIndex;
		$columnToSort = null;
		$sortDir = null;
		$stringToSearch = null;
		$fieldToSearch = array("name","details");
		if(isset($_POST["order"][0]["column"])){
			$sortDir = Sanitize::escape($_POST["order"][0]["dir"]);

			$columnToSort = $_POST["order"][0]["column"];

			$columnToSort = (isset($_POST["columns"][$columnToSort]["data"]) && ($_POST["columns"][$columnToSort]["orderable"]) == "true") ? $_POST["columns"][$columnToSort]["data"] : "name" ;
			$columnToSort = Sanitize::escape($columnToSort);
		}
		if(isset($_POST["search"]["value"])) {
			$stringToSearch = Sanitize::escape($_POST["search"]["value"]);
		}
		$res = $this->model->getAllDataConditions("subjects",$stringToSearch,$fieldToSearch,$columnToSort,$sortDir);

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

			$allAssign = $this->model->searchData('subjectassign', array("subjectId" => $arr[$index]['id']));
			$userIds = array();
			$teachers = array();
			if(count($allAssign) > 0) {
				foreach ($allAssign as $key => $value) {
					$names = $this->model->getData('userlogin', array("id" => $value['userId']));
					if($names != null) {
						array_push($teachers, $names['fname']." ".$names['mname']." ".$names['lname']);
						array_push($userIds, $value['userId']);
					}
				}
			}
			$arr[$index]['userId'] = $userIds;
			$arr[$index]['teachers'] = $teachers;

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

		if(count($arr) >= 1){
			$result['status'] = 1;
		}
		$result['data'] = $arr;
		$result['success'] = ($result['status'] == 1) ? true : false;
		$result['draw'] = $_POST['draw'];
		$result['recordsTotal'] = $totalCountWithoutFilter;
		$result['recordsFiltered'] = $index;
		unset($_POST);
		return print json_encode($result);
	}

	private function deleteSubject($result) {
		if(!isset($_POST['id'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$idToDel = Input::get('id');
			$dataToSearch = array('id' => $idToDel);
			$res = $this->model->getData('subjects',$dataToSearch);
			if($res != null) {
				$deleted = $this->model->deleteData('subjects', $idToDel);
				$pk = $this->model->getDataId("subjectassign",array('subjectId' => $idToDel));
				do {
					if($pk != 0) $this->model->deleteData("subjectassign", $pk);
					$pk = $this->model->getDataId("subjectassign",array('subjectId' => $idToDel));
				}while($pk != 0);
				if($deleted >= 1) {
					$result['status'] = 1;
				}else {
					$result['status'] = -1;
				}
			}else {
				$result['error'] = array("No such subject found.");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
	}

	private function getValidators() {
		if(Session::isLoggedIn(1))
			return array(
				'name' => array(
					'name' => 'Name',
					'required' => true,
					'min' => 1,
					'max' => 255
				),
				'details' => array(
					'name' => 'Details',
					'min' => 1,
					'max' => 1200
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
				)
			);
	}

	private function updateSubject($result) {
		$data = array();
		foreach ($_POST as $key => $value) {
			if(gettype($value) == "boolean" || gettype($value) == "array") {
				$data[$key] = $_POST[$key];
			}else {
				$data[$key] = Input::get($key);
			}			
		}
		$validate = new Validator();
		$validation = $validate->check($_POST, $this->getValidators());
		if($validate->passed()){
			$dataForSearch = array('id' => $data['id']);
			$res = $this->model->searchData('subjects',$dataForSearch);
			if(count($res) >= 1) {
				$idToChange = $data['id'];
				unset($data['id']);
				unset($data['userId']);
				$ret = $this->model->updateData('subjects', $idToChange, $data);
				$pk = $this->model->getDataId("subjectassign",array('subjectId' => $idToChange));
				do {
					if($pk != 0) $this->model->deleteData("subjectassign", $pk);
					$pk = $this->model->getDataId("subjectassign",array('subjectId' => $idToChange));
				}while($pk != 0);
				$toWrite = 0;
				if(count($_POST['userId']) > 0) {
					foreach ($_POST['userId'] as $value) {
						$toWrite = $this->model->registerData('subjectassign', array('subjectId' => $idToChange,
									'userId' => $value));
					}
				}
				if($ret == 1 || ($toWrite != 0)) {
					$result['status'] = 1;
					$result['success'] = true;
				} else {
					$result['status'] = -1;
					$result['errors'] = $validate->addError("Nothing updated!");
				}							
			} else {
				$result['errors'] = $validate->addError("No such subject found.");
				$result['status'] = 0;
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

	private function addSubject($result){
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
			unset($data['userId']);
			$id = $this->model->registerData('subjects', $data);
			if($id != 0){
				$toWrite = 0;
				if(count($_POST['userId']) > 0) {
					foreach ($_POST['userId'] as $value) {
						$toWrite = $this->model->registerData('subjectassign', array(
							'subjectId' => $id, 'userId' => $value));
					}
				}
				$result['status'] = 1;
				$result['success'] = true;
			}else{
				$result['status'] = -1;
				$result['errors'] = $validate->addError("Problem with connection to server!");
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



}

?>