<?php

class Validator {

    private $passed = false;
    private $errors = array();

    /**
    * @param $source : form method ($_GET/$_POST)
    * @param $item : array(2D)
    */
    /*
    example:
        'name': {
            'name': 'Your Name',
            'required': true,
            'min': 2,
            'max': 10
        }
    */
    public function check($source, $items = array()) { 
        $errorMessage = "";
        foreach($items as $item => $rules) { 
            foreach($rules as $rule => $rule_value) {
                $value = htmlentities(trim($source[$item]," "), ENT_QUOTES, 'UTF-8');

                if($rule === 'name') {
                    $itemName = $rule_value;
                }
                if($rule == 'userDefinedError') {
                    $errorMessage = $rule_value;
                }

                if($rule == 'matchName') {
                    $matchName = $rule_value;
                }
                if($rule === 'required' && empty($value)) {
                    $this->addError("{$itemName} is required"); 
                } else if (!empty($value)) {
                    switch($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value) {
                                $errorMessage = ($errorMessage == "") ? "{$itemName} must be a minimum of {$rule_value} characters." : $errorMessage;
                                $this->addError($errorMessage);
                            }
                            break;
                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $errorMessage = ($errorMessage == "") ? "{$itemName} must be a maximum of {$rule_value} characters." : $errorMessage;
                                $this->addError($errorMessage);
                            }
                            break;
                        case 'minLevel':
                            if($value < $rule_value) {
                                $errorMessage = ($errorMessage == "") ? "{$itemName} must be a greater than {$rule_value}." : $errorMessage;
                                $this->addError($errorMessage);
                            }
                            break;
                        case 'maxLevel':
                            if($value > $rule_value) {
                                $errorMessage = ($errorMessage == "") ? "{$itemName} must be a smaller than {$rule_value}." : $errorMessage;
                                $this->addError($errorMessage);
                            }
                            break;
                        case 'matches':
                            if($value != $source[$rule_value]) {
                                $errorMessage = ($errorMessage == "") ? $matchName." must match {$itemName}." : $errorMessage;
                                $this->addError($errorMessage);
                            }
                            break;
                        case 'type':
                            if($rule_value == 'email') {
                                if (!filter_var($source[$item], FILTER_VALIDATE_EMAIL)) {
                                    $errorMessage = ($errorMessage == "") ? "Invalid {$itemName} format" : $errorMessage;
                                    $this->addError($errorMessage);
                                  }
                            }
                            else if ($rule_value == 'number') {
                                if (!is_numeric($source[$item])) {
                                    $errorMessage = ($errorMessage == "") ? "{$itemName} should be numeric value." : $errorMessage;
                                    $this->addError($errorMessage);
                                }
                            }
                            else if($rule_value == 'date') {
                                $test_arr  = explode('-', $source[$item]);
                                if (count($test_arr) == 3) {
                                    if (checkdate($test_arr[0], $test_arr[1], $test_arr[2])) {
                                        $errorMessage = ($errorMessage == "") ? "{$itemName} should be date." : $errorMessage;
                                        $this->addError($errorMessage);
                                    }
                                }else{
                                    $errorMessage = ($errorMessage == "") ? "{$itemName} should be date." : $errorMessage;
                                    $this->addError($errorMessage);
                             }
                        }
                    }
                }
            }
        }

        if(empty($this->errors)) {
            $this->passed = true;
        }
    }

    public function addError($error) {
        $this->errors[] = $error;
    }

    /**
    * @return $errors : array of errors
    */
    public function errors() {
        return $this->errors;
    }

    /**
    * @return false in failure
    * @return true in success
    */
    public function passed() {
        return empty($this->errors);
    }
}


?>