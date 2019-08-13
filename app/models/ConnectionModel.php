<?php

class ConnectionModel extends Model{
	public function __construct() {
		// tablename for the model
		$this->table = 'connection';
		// primary key for the table
		$this->pk = 'id';

		$this->data = array();

		parent::__construct();
	}

	/**
	* This method register Connection with given data
	* @param $data : array
	* @return last Connection id on success
	* @return 0 on failure
	*/
	public function registerConnection($data) {
		$this->setData($data);
		return $this->create();
	}

	/**
	* This method search message with given data
	* @param $data : array
	* @param $sort : array
	* @return array with all matching records
	*/
	public function searchMessage($data, $sort = null) {
		return $this->search($data, $sort);
	}

	/**
	* This method give all message registered
	* @return array of all message
	*/
	public function getAllMessage() {
		return $this->all();
	}

}

		
