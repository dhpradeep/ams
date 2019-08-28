<?php

class User extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		header("Location: ".SITE_URL."/user/users");
	}

	public function logout()
	{
		if(Session::isLoggedIn()) {
			Session::clearSession();
		}
		header("Location: ".SITE_URL."/user/login");
	}

	public function login() 
	{
		if (Session::isLoggedIn()) {
			header("Location: ".SITE_URL."/home/dashboard");
		}
		if (isset($_POST['login'])) { 
			$validate = new Validator();

			$validation = $validate->check($_POST, array(
				'username' => array(
					'name' => 'Username/Email',
					'required' => true,
					'min' => 5,
					'max' => 50
				),
				'passwordHash' => array(
					'name' => 'Password',
					'required' => true,
					'min' => 6,
					'max' => 25
				)
			));
			if ($validate->passed()) {
				$data1 = ['username' => Input::get('username'), 'passwordHash' => md5(Input::get('passwordHash'))];
				$data2 = ['email' => Input::get('username'), 'passwordHash' => md5(Input::get('passwordHash'))];
				$id1 = $this->model->login('userlogin',$data1);
				$id = ($id1 == 0) ? $this->model->login('userlogin',$data2) : $id1;
				if ($id != 0) {
					$inf = $this->model->searchData('userlogin',array('id'=>$id));
					$nameOfUser = $inf[0]['fname']." ".$inf[0]['mname']." ".$inf[0]['lname'];
						Session::setSession('loggedIn', true);
						Session::setSession('uid', $id);
						Session::setSession('uname', $nameOfUser);
						Session::setSession('role', $inf[0]['role']);
						unset($_POST);
						header("Location: ".SITE_URL."/home/dashboard");
				} else {
					$validate->addError("Username/Email and Password combination not matched!");
				}
			}
			unset($_POST);
			$this->model->template = VIEWS_DIR.DS."user".DS."login.php";
			$this->model->data = array('error' => $validate->errors());
			$this->view->render();
		} else {
			$this->model->template = VIEWS_DIR.DS."user".DS."login.php";
			$this->model->data = array();
			$this->view->render();
		}
	}
	

	public function profile() 
	{
		if(!(Session::isLoggedIn(1) || Session::isLoggedIn(2))) {
			header("Location: ".SITE_URL."/user/login");
		}else {
			$this->model->data['activeTab'] = "profile";
			if(isset($_POST)) {
				$validate = new Validator();
				$result = array('status' => 0);
				if (isset($_POST['submit_profile'])) {
					unset($_POST['submit_profile']);					
					$validation = $validate->check($_POST, array(
						'fname' => array(
							'name' => 'First Name',
							'required' => true,
							'min' => 1,
							'max' => 30
						),
						'mname' => array(
							'name' => 'Middle Name',
							'min' => 1,
							'max' => 30
						),
						'lname' => array(
							'name' => 'Last Name',
							'required' => true,
							'min' => 1,
							'max' => 30
						),
						'email' => array(
							'name' => 'User Email',
							'required' => true,
							'min' => 5,
							'max' => 50,
							'type' => 'email'
						)
					));
					if($validate->passed()){
						$data = array();
						$id = Session::getSession('uid');
						foreach ($_POST as $key => $value) {
							$data[$key] = Input::get($key);
						}
						$checkEmail = array('email' => $data['email']);
						$checkId = $this->model->getDataID('userlogin',$checkEmail);
						if(!($checkId == 0 || $checkId == $id)) {
							$validate->addError("Email already exists.");
							$result['status'] = 0;
						} else {
							$id = $this->model->updateData('userlogin',$id, $data);
							if($id == 1){
								$result['status'] = 1;
							}else{
								$result['status'] = -1;
								$validate->addError("Nothing updated.");
							}
						}
					} else {
						$result['status'] = 0;
					}
				}else if(isset($_POST['submit_security'])) {
					$this->model->data['activeTab'] = "security";
					unset($_POST['submit_security']);					
					$validation = $validate->check($_POST, array(
						'username' => array(
							'name' => 'Username',
							'required' => true,
							'min' => 5,
							'max' => 20
							),
						'passwordHash' => array(
							'name' => 'Password',
							'matchName' => 'Confirm Password',
							'matches' => 'cpasswordHash'
						)
					));
					if(strlen(Input::get("passwordHash")) >= 6 && strlen(Input::get("passwordHash")) <= 25 ) {
						$_POST['passwordHash'] = md5(Input::get("passwordHash"));
					} else {
						
						if(strlen(Input::get("passwordHash")) != 0) {
							$validate->addError("Password must be between 6 to 25 characters.");
						}						
						unset($_POST['passwordHash']);
					}
					unset($_POST['cpasswordHash']);
					if($validate->passed()){
						$data = array();
						$id = Session::getSession('uid');
						foreach ($_POST as $key => $value) {
							$data[$key] = Input::get($key);
						}
						$checkUsername = array('username' => $data['username']);
						$checkId = $this->model->getDataID('userlogin',$checkUsername);
						if(!($checkId == 0 || $checkId == $id)) {
							$validate->addError("Username already exists.");
							$result['status'] = 0;
						} else {
							$id = $this->model->updateData('userlogin',$id, $data);
							if($id == 1){
								$result['status'] = 1;
							}else{
								$result['status'] = -1;
								$validate->addError("Nothing updated.");
							}
						}
					} else {
						$result['status'] = 0;
					}
				}
				if($result['status'] == 1) {
					$this->model->data['success'] = true;
				} else {
					$this->model->data['success'] = false;
					$this->model->data['errors'] = $validate->errors();
				}
				unset($_POST);
			}
			$dataToSearch = array("id" => Session::getSession('uid'),
			"role" => Session::getSession("role"));
			$userdata = $this->model->searchData('userlogin',$dataToSearch);
			if(count($userdata[0]) > 0) {
				unset($userdata[0]['passwordHash']);
				$this->model->data['profile'] = $userdata[0];
			}
			$this->model->template = VIEWS_DIR.DS."user".DS."profile.php";
			$this->view->render();
		}
	}

	public function users($name = '') 
	{
		if(($name == "add" || $name == "update" || $name == "delete" || $name == "get") && Session::isLoggedIn(1)) {
			$result = array('status' => 0);	
			if(isset($_POST)) {
				if($name == "get") {
					return $this->getUser($result);
				}
				if($name == "delete") {
					return $this->deleteUser($result);
				}
				if($name == "update" && isset($_POST['id']) && isset($_POST['role'])) {
					return $this->updateUser($result);
				}
				if($name == "add") {
					return $this->addUser($result);
				}	
			}		

		} else if($name == ''){	
			if(Session::isLoggedIn(1)) {
				$this->model->template = VIEWS_DIR.DS."user".DS."users.php";
				$this->view->render();
			}else {
				header("Location: ".SITE_URL."/home/dashboard");
			}			
		} else {
			header("Location: ".SITE_URL."/home/message");
		}
	}

	private function getUser($result) {
		$startIndex = $_POST['start'];
		$totalCount = $_POST['length'];
		$startIndex = ($totalCount == -1) ? 0 : $startIndex;
		$columnToSort = null;
		$sortDir = null;
		$stringToSearch = null;
		$fieldToSearch = array("fname","lname","mname","username","email");
		if(isset($_POST["order"][0]["column"])){
			$sortDir = Sanitize::escape($_POST["order"][0]["dir"]);

			$columnToSort = $_POST["order"][0]["column"];

			$columnToSort = (!isset($_POST["columns"][$columnToSort]["name"]) && $_POST["columns"][$columnToSort]["orderable"]) ? $_POST["columns"][$columnToSort]["name"] : "name" ;
			$columnToSort = ($columnToSort == "name") ? "fname" : Sanitize::escape($columnToSort);
		}
		if(isset($_POST["search"]["value"])) {
			$stringToSearch = Sanitize::escape($_POST["search"]["value"]);
		}
		$finalArray = $this->model->getAllDataConditions('userlogin',$stringToSearch,$fieldToSearch,$columnToSort,$sortDir);
		$res = array();
		$countA = 0;
		foreach ($finalArray as $value) {					
			if(!($value['id'] == Session::getSession('uid')) && !($value['role'] == 3)) {
				$res[$countA++] = $value;
			}
		}

		$totalWithoutFilter = count($res);

		if(isset($_POST['filterData']) && $_POST['filterData'] > 0) {
			$i = 0;
			foreach ($res as $value) {
				if($value['role'] != $_POST['filterData']) {
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
			$res[$i]['name'] = $res[$i]['fname']." ".$res[$i]['mname']. " " .$res[$i]['lname'];
			unset($res[$i]['passwordHash']);
			unset($res[$i]['fname']);
			unset($res[$i]['lname']);
			unset($res[$i]['mname']);
			$arr[$index++] = $res[$i];
		}

		if(count($arr) >= 1){
			$result['status'] = 1;
		}
		$result['data'] = $arr;
		$result['success'] = ($result['status'] == 1) ? true : false;
			$result['draw'] = $_POST['draw'];
			$result['recordsTotal'] = $totalWithoutFilter;
			$result['recordsFiltered'] = $total;
		unset($_POST);
		return print json_encode($result);
	} 

	private function deleteUser($result) {
		if(!isset($_POST['id'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$idToDel = Input::get('id');
			$dataToSearch = array('id' => $idToDel);
			$res = $this->model->searchData('userlogin',$dataToSearch);
			if(count($res) >= 1) {
				$out = $this->model->deleteData('userlogin', $idToDel);
				if($out == 1) {
					$result['status'] = 1;
				}else {
					$result['error'] = array("Connection Problem with server.");
					$result['status'] = 0;
				}
			}else {
				$result['error'] = array("No such user found.");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
	}

	private function updateUser($result) {
		$data = array();
		foreach ($_POST as $key => $value) {
			$data[$key] = Input::get($key);
		}
		$dataForSearch = array('id' => $data['id']);
		$res = $this->model->searchData('userlogin',$dataForSearch);
		if(count($res) >= 1) {
			$idToChange = $data['id'];
			if(!($data['role'] == 1 || $data['role'] == 2 || $data['role'] == 3))
			{
				$result['status'] = 0;
			}else {
				unset($data['id']);
				$ret = $this->model->updateData('userlogin',$idToChange, $data);
				if($ret == 1) {
					$result['status'] = 1;
					$result['success'] = true;
				} else {
					$result['status'] = -1;
					$result['errors'] = array("Nothing updated!");
				}
			}							
		} else {
			$result['errors'] = array("No such user found.");
			$result['status'] = 0;
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
	}

	private function addUser($result){
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'name' => 'Username',
				'required' => true,
				'min' => 5,
				'max' => 20
			),
			'passwordHash' => array(
				'name' => 'Password',
				'required' => true,
				'min' => 6,
				'max' => 25,
				'matchName' => 'Confirm Password',
				'matches' => 'cpasswordHash'
			),
			'fname' => array(
				'name' => 'First Name',
				'required' => true,
				'min' => 1,
				'max' => 30
			),
			'mname' => array(
				'name' => 'Middle Name',
				'min' => 1,
				'max' => 30
			),
			'lname' => array(
				'name' => 'Last Name',
				'required' => true,
				'min' => 1,
				'max' => 30
			),
			'email' => array(
				'name' => 'User Email',
				'required' => true,
				'min' => 5,
				'max' => 50,
				'type' => 'email'
			)
		));
		if($validate->passed()){
			unset($_POST['cpasswordHash']);
			$data = array();
			$data['id'] = null;
			foreach ($_POST as $key => $value) {
				$data[$key] = Input::get($key);
			}
			$data["passwordHash"] = md5($data['passwordHash']);
			if($data['role'] == "Admin"){
				$data['role'] = 1;
			}else if($data['role'] == "Teacher"){
				$data['role'] = 2;
			}else {
				$data['role'] = 0;
			}
			$checkUsername = array('username' => $data['username']);
			$checkEmail = array('email' => $data['email']);
			if ($this->model->getDataID('userlogin',$checkUsername) != 0) {
				$validate->addError("Username already exists.");
				$result['status'] = 0;
			} else if($this->model->getDataID('userlogin',$checkEmail) != 0) {
				$validate->addError("Email already exists.");
				$result['status'] = 0;
			} else {
				$id = $this->model->registerData('userlogin',$data);
				if($id != 0){
					$result['status'] = 1;
					$result['success'] = true;
				}else{
					$result['status'] = -1;
					$result['errors'] = $validate->addError("Problem with connection to server!");
				}
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
 