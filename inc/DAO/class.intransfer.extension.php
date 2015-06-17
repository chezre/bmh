<?php

Class extendedInTransfer extends intransfer { 
 	function Save() {
 	 	$acceptDate = (empty($this->trf_accepted_date)) ? 'null':"'$this->trf_accepted_date'";
 	 	$rejectDate = (empty($this->trf_rejected_date)) ? 'null':"'$this->trf_rejected_date'";
		if (isset($this->trf_id) && !empty($this->trf_id)) {
		$sql = "
	            UPDATE `inTransfer` SET
	              `trf_pet_id` = '$this->trf_pet_id',
	              `trf_old_usr_id` = '$this->trf_old_usr_id',
	              `trf_new_usr_id` = '$this->trf_new_usr_id',
	              `trf_date` = '$this->trf_date',
	              `trf_accepted_date` = $acceptDate,
	              `trf_rejected_date` = $rejectDate
	            WHERE
	                `trf_id` = '$this->trf_id';";
	    } ELSE {
	    $sql = "
	            INSERT INTO `inTransfer` (
	              `trf_pet_id`,
	              `trf_old_usr_id`,
	              `trf_new_usr_id`,
	              `trf_date`
	    ) VALUES (
	              '$this->trf_pet_id',
	              '$this->trf_old_usr_id',
	              '$this->trf_new_usr_id',
	              '".date("Y-m-d H:i:s")."'
	    );";
	    }
	    $result = $GLOBALS['db']->execute($sql);
	    $this->trf_id = (empty($this->trf_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->trf_id;
	}
}

?>