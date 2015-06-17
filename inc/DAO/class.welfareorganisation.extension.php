<?php

Class extendedWelfareOrganisation extends welfareorganisation { 
 	
 	function LoadByUserId($userId) {
		if (empty($userId)) return false;
		$sql = "SELECT * FROM `welfareOrganisation` where `wel_usr_id` = $userId;";
		$result = $GLOBALS['db']->select($sql);
		if (!empty($result)) {
		 	foreach ($result[0] as $k => $v) $this->$k = stripslashes($v);
		 	return true;
		} else {
			return false;
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
	              `wel_verified_by_admin` = '$this->wel_verified_by_admin'
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
	              `wel_contact_mobile_number`
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
	              '$this->wel_contact_mobile_number'
	    );";
	    }
	    $result = $GLOBALS['db']->execute($sql);
	    $this->wel_id = (empty($this->wel_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->wel_id;
		
	}
}

?>