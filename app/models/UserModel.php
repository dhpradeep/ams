<?php

class UserModel extends Model{

	public function __construct() {
		// tablename for the model
		$this->table = 'userlogin';
		// primary key for the table
		$this->pk = 'id';
		
		$this->data = array();

		parent::__construct();
	}

	/**
	* @param $data : array
	* @return first id with given data.
	* @return 0 if fail
	*/
	public function getUserID($data) {
		return $this->getPk($data);
	}

	/**
	* This method register user with given data
	* @param $data : array
	* @return last user id on success
	* @return 0 on failure
	*/
	public function registerUser($data) {
		$this->setData($data);
		return $this->create();
	}

	/**
	* This method search user with given data
	* @param $data : array
	* @param $sort : array
	* @return array with all matching records
	*/
	public function searchUser($data, $sort = null) {
		return $this->search($data, $sort);
	}

	/**
	* This method delete user with given id
	* @param $id : num
	* @return 1 on success
	* @return 0 on failure
	*/
	public function deleteUser($id) {
		 return $this->delete($id);
	}


	/**
	* This method login user with given data
	* @param $data : array with 'email' or 'usname' and 'pwd'
	* @return id on success
	* @return 0 on failure
	*/
	public function login($data) {
		if((isset($data['username']) || isset($data['email'])) && isset($data['passwordHash'])) {
			return $this->getPk($data);
		}		
	}

	/**
	* This method update user with given id
	* @param $id : num
	* @param $data : array -> data to update
	* @return 1 on success
	* @return 0 on failure
	*/
	public function updateUser($id, $data) {
		$this->setData($data);
		return $this->update($id);
	}

	/**
	* This method give all user registered
	* @return array of all user
	*/
	public function getAllUser() {
		return $this->all();
	}

	/**
	* This method return whole table of user as array with conditions.
	* @param $search : search keyword;
	* @param $searchField : array of field names to be searched;
	* @param $sort : sorting fieldname
	* @param $sortType : 'ASC' or 'DSC'
	* @return whole table as array.  
	*/
	public function getAllUserConditions($search = null, $searchFields = null, $sort = null, $sortType = ''){
		return $this->allConditions($search,$searchFields,$sort,$sortType);
	}
}

?>