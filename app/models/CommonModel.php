<?php

class CommonModel extends Model{

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
	public function getDataId($table, $data) {
		$this->setTable($table);
		return $this->getPk($data);
	}

	/**
	* This method register data with given info
	* @param $data : array
	* @return last data id on success
	* @return 0 on failure
	*/
	public function registerData($table, $data) {
		$this->setTable($table);
		$this->setData($data);
		return $this->create();
	}

	/**
	* This method search data with given info
	* @param $data : array
	* @param $sort : array
	* @return array with all matching records
	*/
	public function searchData($table, $data, $sort = null) {
		$this->setTable($table);
		return $this->search($data, $sort);
	}

	/**
	* This method search data with given info and return first data set
	* @param $data : array
	* @param $sort : array
	* @return array with all matching records
	*/
	public function getData($table, $data, $sort = null) {
		$this->setTable($table);
		$toReturn = $this->search($data, $sort);
		return (count($toReturn) > 0) ? $toReturn[0] : null;
	}

	/**
	* This method delete data with given id
	* @param $id : num
	* @return 1 on success
	* @return 0 on failure
	*/
	public function deleteData($table, $id) {
		$this->setTable($table);
		 return $this->delete($id);
	}


	/**
	* This method is used to get for login data id with given info
	* @param $data : array with 'email' or 'usname' and 'pwd'
	* @return id on success
	* @return 0 on failure
	*/
	public function login($table, $data) {
		$this->setTable($table);
		if((isset($data['username']) || isset($data['email'])) && isset($data['passwordHash'])) {
			return $this->getPk($data);
		}		
	}

	/**
	* This method update data with given id
	* @param $id : num
	* @param $data : array -> info to update
	* @return 1 on success
	* @return 0 on failure
	*/
	public function updateData($table, $id, $data) {
		$this->setTable($table);
		$this->setData($data);
		return $this->update($id);
	}

	/**
	* This method give all data registered
	* @return array of all data
	*/
	public function getAllData($table) {
		$this->setTable($table);
		return $this->all();
	}

	/**
	* This method return whole table of data as array with conditions.
	* @param $search : search keyword;
	* @param $searchField : array of field names to be searched;
	* @param $sort : sorting fieldname
	* @param $sortType : 'ASC' or 'DSC'
	* @return whole table as array.  
	*/
	public function getAllDataConditions($table, $search = null, $searchFields = null, $sort = null, $sortType = ''){
		$this->setTable($table);
		return $this->allConditions($search,$searchFields,$sort,$sortType);
	}

	/**
	* This method return data with range and conditions
	* @param $compareField : the field to be compared;
	* @param $startRange : minimum range;
	* @param $endRange : maximum range;
	* @param $field : conditional fields;
	* @return whole data meeting the conditions and range.  
	*/
	public function rangeData($table, $compareField, $startRange, $endRange, $fields = null){
		$this->setTable($table);
		$sql = "SELECT * FROM " . $this->table;
			$sql .= " WHERE ".$compareField. " BETWEEN '".$startRange."' AND '".$endRange."' ";
		if (!empty($fields)) {
			$fieldsvals = array();
			$columns = array_keys($fields);
			foreach($columns as $column) {
				array_push($fieldsvals, $column . " = :". $column);
			}
			$sql .= " AND " . implode(" AND ", $fieldsvals);
		}
		return $this->exec($sql, $fields);
	}

}

?>