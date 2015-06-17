<?php

Class adminstaff { 

var $adm_id;
var $adm_usr_id;
var $adm_name;

function Load($id) {
	if (empty($id)) return false;
    $sql = "SELECT * FROM `adminStaff` where `adm_id` = $id";
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
	
	if (isset($this->adm_id) && !empty($this->adm_id)) {
	$sql = "
            UPDATE `adminStaff` SET
              `adm_usr_id` = '$this->adm_usr_id',
              `adm_name` = '$this->adm_name'
            WHERE
                `adm_id` = '$this->adm_id';";
    } ELSE {
    $sql = "
            INSERT INTO `adminStaff` (
              `adm_usr_id`,
              `adm_name`
    ) VALUES (
              '$this->adm_usr_id',
              '$this->adm_name'
    );";
    }
    $result = $GLOBALS['db']->execute($sql);
    $this->adm_id = (empty($this->adm_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->adm_id;
	
}

# end class	
}

?>