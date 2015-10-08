<?php

Class extendedPet extends pet { 
 	
 	function Save() {
	
		$vacDate = (empty($this->pet_next_vaccination_date)) ? 'null':"'$this->pet_next_vaccination_date'";
		$regDate = (empty($this->pet_register_date)) ? 'null':"'$this->pet_register_date'";
		$certDate = (empty($this->pet_certificate_emailed)) ? 'null':"'$this->pet_certificate_emailed'";
		$implantedDate = (empty($this->pet_implanted_date)) ? 'null':"'$this->pet_implanted_date'";
		
		$usrId = (empty($this->pet_usr_id)) ? 'null':"'$this->pet_usr_id'";
		if (isset($this->pet_id) && !empty($this->pet_id)) {
		$sql = "
	            UPDATE `pet` SET
	              `pet_rfid` = '$this->pet_rfid',
	              `pet_usr_id` = $usrId,
	              `pet_name` = '$this->pet_name',
	              `pet_sex` = '$this->pet_sex',
	              `pet_sterilized` = '$this->pet_sterilized',
	              `pet_breed` = '$this->pet_breed',
	              `pet_species` = '$this->pet_species',
	              `pet_birthdate` = '$this->pet_birthdate',
	              `pet_distinguishing_features` = '$this->pet_distinguishing_features',
	              `pet_breeder_society` = '$this->pet_breeder_society',
	              `pet_photo_1` = '$this->pet_photo_1',
	              `pet_photo_2` = '$this->pet_photo_2',
	              `pet_photo_3` = '$this->pet_photo_3',
	              `pet_photo_4` = '$this->pet_photo_4',
	              `pet_general_notes` = '$this->pet_general_notes',
	              `pet_weight` = '$this->pet_weight',
	              `pet_next_vaccination_date` = $vacDate,
                  `pet_next_vaccination_vet_usr_id` = '$this->pet_next_vaccination_vet_usr_id',
	              `pet_status` = '$this->pet_status',
	              `pet_register_date` = $regDate,
	              `pet_height` = '$this->pet_height',
	              `pet_assigned_by_usr_id` = '$this->pet_assigned_by_usr_id',
				  `pet_certificate_emailed` = $certDate,
				  `pet_colour` = '$this->pet_colour',
				  `pet_implanted_date` = $implantedDate
	            WHERE
	              `pet_id` = '$this->pet_id';";
	    } ELSE {
	    $sql = "
	            INSERT INTO `pet` (
	              `pet_rfid`,
	              `pet_usr_id`,
	              `pet_name`,
	              `pet_sex`,
	              `pet_sterilized`,
	              `pet_breed`,
	              `pet_species`,
	              `pet_birthdate`,
	              `pet_distinguishing_features`,
	              `pet_breeder_society`,
	              `pet_photo_1`,
	              `pet_photo_2`,
	              `pet_photo_3`,
	              `pet_photo_4`,
	              `pet_general_notes`,
	              `pet_weight`,
	              `pet_next_vaccination_date`,
	              `pet_status`,
                  `pet_next_vaccination_vet_usr_id`,
                  `pet_height`,
                  `pet_assigned_by_usr_id`,
				  `pet_certificate_emailed`,
				  `pet_colour`,
				  `pet_implanted_date`
	    ) VALUES (
	              '$this->pet_rfid',
	              '$this->pet_usr_id',
	              '$this->pet_name',
	              '$this->pet_sex',
	              '$this->pet_sterilized',
	              '$this->pet_breed',
	              '$this->pet_species',
	              '$this->pet_birthdate',
	              '$this->pet_distinguishing_features',
	              '$this->pet_breeder_society',
	              '$this->pet_photo_1',
	              '$this->pet_photo_2',
	              '$this->pet_photo_3',
	              '$this->pet_photo_4',
	              '$this->pet_general_notes',
	              '$this->pet_weight',
	              '$vacDate',
		      '$this->pet_status',
              '$this->pet_next_vaccination_vet_usr_id',
              '$this->pet_height',
              '$this->pet_assigned_by_usr_id',
			  $certDate,
			  '$this->pet_colour',
			  $implantedDate
	    );";
	    }
	    $result = $GLOBALS['db']->execute($sql);
	    $this->pet_id = (empty($this->pet_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->pet_id;
		return $sql;
	}
	
	function Import() {
	
		$sql = "INSERT INTO `pet` (
		      `pet_rfid`,
		      `pet_invoice_no`
		) VALUES (
		      '$this->pet_rfid',
		      '$this->pet_invoice_no'
		);";
		$result = $GLOBALS['db']->execute($sql);
		$this->pet_id = $GLOBALS['db']->connection->lastInsertId();
		return (!empty($this->pet_id));
	}
	
	function LoadByRFID($id) {
		
		if (empty($id)) return false;
	    $sql = "SELECT * FROM `pet` where `pet_rfid` = $id";
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
	
	function ResetMicrochip() {
	
		if (isset($this->pet_id) && !empty($this->pet_id)) {
			$sql = "
	            UPDATE `pet` SET
				  `pet_usr_id` = null,
	              `pet_name` = null,
	              `pet_sex` = null,
	              `pet_sterilized` = null,
	              `pet_breed` = null,
	              `pet_species` = null,
	              `pet_birthdate` = null,
	              `pet_distinguishing_features` = null,
	              `pet_breeder_society` = null,
	              `pet_photo_1` = null,
	              `pet_photo_2` = null,
	              `pet_photo_3` = null,
	              `pet_photo_4` = null,
	              `pet_general_notes` = null,
	              `pet_weight` = null,
	              `pet_next_vaccination_date` = null,
                  `pet_next_vaccination_vet_usr_id` = null,
	              `pet_status` = 'ok',
	              `pet_register_date` = null,
	              `pet_height` = null,
	              `pet_assigned_by_usr_id` = null,
				  `pet_certificate_emailed` = null,
				  `pet_colour` = null,
				  `pet_implanted_date` = null
	            WHERE
	              `pet_id` = '$this->pet_id';";
		}
		
	    
		$rowCount = $GLOBALS['db']->execute($sql);
		return ($rowCount==1) ? $rowCount . ' row updated':$rowCount . ' rows updated';
	}
}