<?php 

class TokenModel extends Model{

	public function __construct() {
		// tablename for the model
		$this->table = 'token';
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
	public function getTokenID($data) {
		return $this->getPk($data);
	}

	/**
	* This method generate a random token
	* @return a random token unique than from database.
	*/
	public function generateToken() {
        do {
        		$token = md5(uniqid());
        } while($this->getPk(array('token' => $token)) != 0);
        return $token;
    }

    /**
	* This method register user with given data
	* @param $data : array
	* @return last token id on success
	* @return 0 on failure
	*/
	public function registerToken($data) {
		$this->setData($data);
		return $this->create();
	}

	/**
	* This method check validity of token
	* @param $token and $min => minutes to be valid
	* @return 1 on valid 
	* @return 0 on invalid
	*/
	public function isValid($token, $min) {
		if(($id = $this->getTokenID(array('token' => $token))) != 0) {
			$this->load($id);			
			$tokenTime= strtotime($this->tokenTime);
			$now = time();
			$diff = ($now - $tokenTime)/60;
			if($diff > $min) return 0;
			return 1;
		}
	}

	/**
	* This method is to get token id, uid, type and time
	* @param $token
	* @return array on sucess
	* @return 0 on failure
	*/
	public function getTokenData($token) {
		if(($id = $this->getTokenID(array('token' => $token))) != 0) {
			$this->load($id);
			return $this->variables;
		}
		return 0;
	}

	/**
	* This method delete token with given id
	* @param $id : num
	* @return 1 on success
	* @return 0 on failure
	*/
	public function deleteToken($id) {
		 return $this->delete($id);
	}









}

?>