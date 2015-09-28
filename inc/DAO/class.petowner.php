<?php

Class petowner { 

var $pow_id;
var $pow_usr_id;
var $pow_first_name;
var $pow_last_name;
var $pow_address_1;
var $pow_address_2;
var $pow_address_3;
var $pow_postal_code;
var $pow_country;
var $pow_cellphone_no;
var $pow_telephone_no;

function Load($id) {
	if (empty($id)) return false;
    $sql = "SELECT * FROM `petOwner` where `pow_id` = $id";
    $result = $GLOBALS['db']->select($sql);
    if (!$result) {
    	return false;
    } else {
    	foreach ($result[0] as $k => $v) {
    		$this->$k = stripslashes($v);
    	}
    	return true;
    }
}

function Save() {
	
	if (isset($this->pow_id) && !empty($this->pow_id)) {
	$sql = "
            UPDATE `petOwner` SET
              `pow_usr_id` = '$this->pow_usr_id',
              `pow_first_name` = '$this->pow_first_name',
              `pow_last_name` = '$this->pow_last_name',
              `pow_address_1` = '$this->pow_address_1',
              `pow_address_2` = '$this->pow_address_2',
              `pow_address_3` = '$this->pow_address_3',
              `pow_postal_code` = '$this->pow_postal_code',
              `pow_country` = '$this->pow_country',
              `pow_cellphone_no` = '$this->pow_cellphone_no',
              `pow_telephone_no` = '$this->pow_telephone_no'
            WHERE
                `pow_id` = '$this->pow_id';";
    } ELSE {
    $sql = "
            INSERT INTO `petOwner` (
              `pow_usr_id`,
              `pow_first_name`,
              `pow_last_name`,
              `pow_address_1`,
              `pow_address_2`,
              `pow_address_3`,
              `pow_postal_code`,
              `pow_country`,
              `pow_cellphone_no`,
              `pow_telephone_no`
    ) VALUES (
              '$this->pow_usr_id',
              '$this->pow_first_name',
              '$this->pow_last_name',
              '$this->pow_address_1',
              '$this->pow_address_2',
              '$this->pow_address_3',
              '$this->pow_postal_code',
              '$this->pow_country',
              '$this->pow_cellphone_no',
              '$this->pow_telephone_no'
    );";
    }
    $result = $GLOBALS['db']->execute($sql);
    $this->pow_id = (empty($this->pow_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->pow_id;
	
}

# end class	
}

?>