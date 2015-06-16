<?php

Class usertype { 

var $uty_id;
var $uty_table;
var $uty_landing_page;
var $uty_default_role_id;

function Load($id) {
	if (empty($id)) return false;
    $sql = "SELECT * FROM `userType` where `uty_id` = $id";
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
	
	if (isset($this->uty_id) && !empty($this->uty_id)) {
	$sql = "
            UPDATE `userType` SET
              `uty_table` = '$this->uty_table',
              `uty_landing_page` = '$this->uty_landing_page',
              `uty_default_role_id` = '$this->uty_default_role_id'
            WHERE
                `uty_id` = '$this->uty_id';";
    } ELSE {
    $sql = "
            INSERT INTO `userType` (
              `uty_table`,
              `uty_landing_page`,
              `uty_default_role_id`
    ) VALUES (
              '$this->uty_table',
              '$this->uty_landing_page',
              '$this->uty_default_role_id'
    );";
    }
    $result = $GLOBALS['db']->execute($sql);
    $this->uty_id = (empty($this->uty_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->uty_id;
	
}

# end class	
}

?>