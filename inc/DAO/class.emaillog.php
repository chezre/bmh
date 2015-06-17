<?php

Class emaillog{ 

	var $elg_id;
	var $elg_xml;
	var $elg_result;
	var $elg_send_datetime;
	var $elg_usr_id;
	
	function Load($id) {
		if (empty($id)) return false;
	    $sql = "SELECT * FROM `emailLog` where `elg_id` = $id";
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
		if (isset($this->elg_id) && !empty($this->elg_id)) {
		$sql = "
	            UPDATE `emailLog` SET
	              `elg_xml` = '$this->elg_xml',
				  `elg_result` = '$this->elg_result',
	              `elg_send_datetime` = '$this->elg_send_datetime',
	              `elg_usr_id` = '$this->elg_usr_id'
	            WHERE
	                `elg_id` = '$this->elg_id';";
	    } ELSE {
	    $sql = "
	            INSERT INTO `emailLog` (
	              `elg_xml`,
	              `elg_result`,
	              `elg_send_datetime`,
	              `elg_usr_id`
	    ) VALUES (
	              '$this->elg_xml',
	              '$this->elg_result',
	              '$this->elg_send_datetime',
	              '$this->elg_usr_id'
	    );";
	    }
	    $result = $GLOBALS['db']->execute($sql);
	    $this->elg_id = (empty($this->elg_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->elg_id;
		
	}

# end class	
}