<?php

Class vaccinationhistory { 

var $vhi_id;
var $vhi_usr_id;
var $vhi_pet_id;
var $vhi_name;
var $vhi_batch_no;
var $vhi_note;
var $vhi_date;

function Load($id) {
	if (empty($id)) return false;
    $sql = "SELECT * FROM `vaccinationHistory` where `vhi_id` = $id";
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
	
	if (isset($this->vhi_id) && !empty($this->vhi_id)) {
	$sql = "
            UPDATE `vaccinationHistory` SET
              `vhi_usr_id` = '$this->vhi_usr_id',
              `vhi_pet_id` = '$this->vhi_pet_id',
              `vhi_name` = '$this->vhi_name',
              `vhi_batch_no` = '$this->vhi_batch_no',
              `vhi_note` = '$this->vhi_note',
              `vhi_date` = '$this->vhi_date'
            WHERE
                `vhi_id` = '$this->vhi_id';";
    } ELSE {
    $sql = "
            INSERT INTO `vaccinationHistory` (
              `vhi_usr_id`,
              `vhi_pet_id`,
              `vhi_name`,
              `vhi_batch_no`,
              `vhi_note`,
              `vhi_date`
    ) VALUES (
              '$this->vhi_usr_id',
              '$this->vhi_pet_id',
              '$this->vhi_name',
              '$this->vhi_batch_no',
              '$this->vhi_note',
              '$this->vhi_date'
    );";
    }
    $result = $GLOBALS['db']->execute($sql);
    $this->vhi_id = (empty($this->vhi_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->vhi_id;
	
}

# end class	
}

?>