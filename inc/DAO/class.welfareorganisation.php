<?php

Class welfareorganisation { 

var $wel_id;
var $wel_usr_id;
var $wel_name;
var $wel_address_1;
var $wel_address_2;
var $wel_address_3;
var $wel_city;
var $wel_postal_code;
var $wel_country;
var $wel_contact_fullname;
var $wel_contact_number;
var $wel_contact_mobile_number;
var $wel_verified_by_admin;
var $wel_registration_date;

function Load($id) {
	
	if (empty($id)) return false;
    $sql = "SELECT * FROM `welfareOrganisation` where `wel_id` = $id";
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
	
	if (isset($this->wel_id) && !empty($this->wel_id)) {
	$sql = "
            UPDATE `welfareOrganisation` SET
              `wel_usr_id` = '$this->wel_usr_id',
              `wel_name` = '$this->wel_name',
              `wel_address_1` = '$this->wel_address_1',
              `wel_address_2` = '$this->wel_address_2',
              `wel_address_3` = '$this->wel_address_3',
              `wel_city` = '$this->wel_city',
              `wel_postal_code` = '$this->wel_postal_code',
              `wel_country` = '$this->wel_country',
              `wel_contact_fullname` = '$this->wel_contact_fullname',
              `wel_contact_number` = '$this->wel_contact_number',
              `wel_contact_mobile_number` = '$this->wel_contact_mobile_number',
              `wel_verified_by_admin` = '$this->wel_verified_by_admin',
              `wel_registration_date` = '$this->wel_registration_date'
            WHERE
                `wel_id` = '$this->wel_id';";
    } ELSE {
    $sql = "
            INSERT INTO `welfareOrganisation` (
              `wel_usr_id`,
              `wel_name`,
              `wel_address_1`,
              `wel_address_2`,
              `wel_address_3`,
              `wel_city`,
              `wel_postal_code`,
              `wel_country`,
              `wel_contact_fullname`,
              `wel_contact_number`,
              `wel_contact_mobile_number`,
              `wel_verified_by_admin`,
              `wel_registration_date`
    ) VALUES (
              '$this->wel_usr_id',
              '$this->wel_name',
              '$this->wel_address_1',
              '$this->wel_address_2',
              '$this->wel_address_3',
              '$this->wel_city',
              '$this->wel_postal_code',
              '$this->wel_country',
              '$this->wel_contact_fullname',
              '$this->wel_contact_number',
              '$this->wel_contact_mobile_number',
              '$this->wel_verified_by_admin',
              '$this->wel_registration_date'
    );";
    }
    $result = $GLOBALS['db']->execute($sql);
    $this->wel_id = (empty($this->wel_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->wel_id;
	
}

# end class	
}

?>