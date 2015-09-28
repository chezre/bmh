<?php

Class extendedAdminStaff extends adminstaff { 
 	
 	function LoadByUserId($userId) {
		if (empty($userId)) return false;
		$sql = "SELECT * FROM `adminStaff` where `adm_usr_id` = $userId;";
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
