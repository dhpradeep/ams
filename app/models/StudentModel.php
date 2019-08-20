<?php

class StudentModel extends Model{

	public function __construct() {
		// tablename for the model
		$this->table = 'personaldata';
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
	public function getStudentId($data) {
		return $this->getPk($data);
	}

	/**
	* This method register student with given data
	* @param $data : array
	* @return last student id on success
	* @return 0 on failure
	*/
	public function registerStudent($data) {
		$this->setData($data);
		return $this->create();
	}

	/**
	* This method search student with given data
	* @param $data : array
	* @param $sort : array
	* @return array with all matching records
	*/
	public function searchStudent($data, $sort = null) {
		return $this->search($data, $sort);
	}

	/**
	* This method delete student with given id
	* @param $id : num
	* @return 1 on success
	* @return 0 on failure
	*/
	public function deleteStudent($id) {
		 return $this->delete($id);
	}

	/**
	* This method update student with given id
	* @param $id : num
	* @param $data : array -> data to update
	* @return 1 on success
	* @return 0 on failure
	*/
	public function updateStudent($id, $data) {
		$this->setData($data);
		return $this->update($id);
	}

	/**
	* This method give all student registered
	* @return array of all student
	*/
	public function getAllStudent() {
		return $this->all();
	}

	/**
	* This method return whole table of student as array with conditions.
	* @param $search : search keyword;
	* @param $searchField : array of field names to be searched;
	* @param $sort : sorting fieldname
	* @param $sortType : 'ASC' or 'DSC'
	* @return whole table as array.  
	*/
	public function getAllStudentConditions($search = null, $searchFields = null, $sort = null, $sortType = ''){
		return $this->allConditions($search,$searchFields,$sort,$sortType);
	}
}

?>