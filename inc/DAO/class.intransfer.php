<?php

Class intransfer { 

var $trf_id;
var $trf_pet_id;
var $trf_old_usr_id;
var $trf_new_usr_id;
var $trf_date;
var $trf_accepted_date;
var $trf_rejected_date;

function Load($id) {
	if (empty($id)) return false;
    $sql = "SELECT * FROM `inTransfer` where `trf_id` = $id";
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
	
	if (isset($this->trf_id) && !empty($this->trf_id)) {
	$sql = "
            UPDATE `inTransfer` SET
              `trf_pet_id` = '$this->trf_pet_id',
              `trf_old_usr_id` = '$this->trf_old_usr_id',
              `trf_new_usr_id` = '$this->trf_new_usr_id',
              `trf_date` = '$this->trf_date',
              `trf_accepted_date` = '$this->trf_accepted_date',
              `trf_rejected_date` = '$this->trf_rejected_date'
            WHERE
                `trf_id` = '$this->trf_id';";
    } ELSE {
    $sql = "
            INSERT INTO `inTransfer` (
              `trf_pet_id`,
              `trf_old_usr_id`,
              `trf_new_usr_id`,
              `trf_date`,
              `trf_accepted_date`,
              `trf_rejected_date`
    ) VALUES (
              '$this->trf_pet_id',
              '$this->trf_old_usr_id',
              '$this->trf_new_usr_id',
              '$this->trf_date',
              '$this->trf_accepted_date',
              '$this->trf_rejected_date'
    );";
    }
    $result = $GLOBALS['db']->execute($sql);
    $this->trf_id = (empty($this->trf_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->trf_id;
	
}

# end class	
}

?>