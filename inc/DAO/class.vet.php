<?php

Class vet { 

var $vet_id;
var $vet_practice_no;
var $vet_usr_id;
var $vet_name;
var $vet_practice_name;
var $vet_practice_address_1;
var $vet_practice_address_2;
var $vet_practice_address_3;
var $vet_practice_postal_code;
var $vet_cellphone_no;
var $vet_practice_telephone_no;
var $vet_practice_fax_no;
var $vet_verified_by_admin;
var $vet_registration_date;
var $vet_statutory_id;

function Load($id) {

	if (empty($id)) return false;
    $sql = "SELECT * FROM `vet` where `vet_id` = $id";
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
	
	if (isset($this->vet_id) && !empty($this->vet_id)) {
	$sql = "
            UPDATE `vet` SET
              `vet_practice_no` = '$this->vet_practice_no',
              `vet_usr_id` = '$this->vet_usr_id',
              `vet_name` = '$this->vet_name',
              `vet_practice_name` = '$this->vet_practice_name',
              `vet_practice_address_1` = '$this->vet_practice_address_1',
              `vet_practice_address_2` = '$this->vet_practice_address_2',
              `vet_practice_address_3` = '$this->vet_practice_address_3',
              `vet_practice_postal_code` = '$this->vet_practice_postal_code',
              `vet_cellphone_no` = '$this->vet_cellphone_no',
              `vet_practice_telephone_no` = '$this->vet_practice_telephone_no',
              `vet_practice_fax_no` = '$this->vet_practice_fax_no',
              `vet_verified_by_admin` = '$this->vet_verified_by_admin',
              `vet_registration_date` = '$this->vet_registration_date',
              `vet_statutory_id` = '$this->vet_statutory_id'
            WHERE
                `vet_id` = '$this->vet_id';";
    } ELSE {
    $sql = "
            INSERT INTO `vet` (
              `vet_practice_no`,
              `vet_usr_id`,
              `vet_name`,
              `vet_practice_name`,
              `vet_practice_address_1`,
              `vet_practice_address_2`,
              `vet_practice_address_3`,
              `vet_practice_postal_code`,
              `vet_cellphone_no`,
              `vet_practice_telephone_no`,
              `vet_practice_fax_no`,
              `vet_verified_by_admin`,
              `vet_registration_date`,
              `vet_statutory_id`
    ) VALUES (
              '$this->vet_practice_no',
              '$this->vet_usr_id',
              '$this->vet_name',
              '$this->vet_practice_name',
              '$this->vet_practice_address_1',
              '$this->vet_practice_address_2',
              '$this->vet_practice_address_3',
              '$this->vet_practice_postal_code',
              '$this->vet_cellphone_no',
              '$this->vet_practice_telephone_no',
              '$this->vet_practice_fax_no',
              '$this->vet_verified_by_admin',
              '$this->vet_registration_date',
              '$this->vet_statutory_id'
    );";
    }
    $result = $GLOBALS['db']->execute($sql);
    $this->vet_id = (empty($this->vet_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->vet_id;
	
}

# end class	
}

?>