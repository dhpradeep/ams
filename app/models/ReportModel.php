<?php

class ReportModel extends Model{
	public function __construct() {
		// tablename for the model
		$this->table = '';
		// primary key for the table
		$this->pk = 'id';

		$this->data = array();

		parent::__construct();
	}

	/** 
	* Set table for the model
	* @param $tablename
	*/

	public function registerTable($tablename) {
		$this->table = $tablename;
	}

	/**
	* This method register data
	* @param $data : array
	* @return last message id on success
	* @return 0 on failure
	*/
	public function registerData($data) {
		$this->setData($data);
		return $this->create();
	}

	/**
	* This method search data with given information
	* @param $data : array
	* @param $sort : array
	* @return array with all matching records
	*/
	public function searchData($data, $sort = null) {
		return $this->search($data, $sort);
	}

	/**
	* This method give all data registered
	* @return array of all data
	*/
	public function getAllData() {
		return $this->all();
	}

	
	/**
	* @param $data : array
	* @return first id with given data.
	* @return 0 if fail
	*/
	public function getDataID($data) {
		return $this->getPk($data);
	}


	/**
	* This method delete data with given id
	* @param $id : num
	* @return 1 on success
	* @return 0 on failure
	*/
	public function deleteData($id) {
		 return $this->delete($id);
	}


}

		
