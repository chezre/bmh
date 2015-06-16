<?php

Class extendedPetOwner extends petowner { 
 	
 	function LoadByUserId($userId) {
		if (empty($userId)) return false;
		$sql = "SELECT * FROM `petOwner` where `pow_usr_id` = $userId;";
		$result = $GLOBALS['db']->select($sql);
		if (!empty($result)) {
		 	foreach ($result[0] as $k => $v) $this->$k = stripslashes($v);
		 	return true;
		} else {
			return false;
		}
	}
}

?>
