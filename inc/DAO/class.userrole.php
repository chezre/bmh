<?php

Class userrole { 

var $rol_id;
var $rol_description;

function Load($id) {
	if (empty($id)) return false;
    $sql = "SELECT * FROM `userRole` where `rol_id` = $id";
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
	
	if (isset($this->rol_id) && !empty($this->rol_id)) {
	$sql = "
            UPDATE `userRole` SET
              `rol_description` = '$this->rol_description'
            WHERE
                `rol_id` = '$this->rol_id';";
    } ELSE {
    $sql = "
            INSERT INTO `userRole` (
              `rol_description`
    ) VALUES (
              '$this->rol_description'
    );";
    }
    $result = $GLOBALS['db']->execute($sql);
    $this->rol_id = (empty($this->rol_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->rol_id;
	
}

# end class	
}

?>