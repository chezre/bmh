<?php

Class user { 

var $usr_id;
var $usr_email;
var $usr_password;
var $usr_type_id;
var $usr_created_datetime;
var $usr_email_verification_key;
var $usr_email_verified;
var $usr_verified_datetime;
var $usr_role_id;
var $usr_password_reset_required;

function Load($id) {
	if (empty($id)) return false;
    $sql = "SELECT * FROM `user` where `usr_id` = $id";
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
	
	if (isset($this->usr_id) && !empty($this->usr_id)) {
	$sql = "
            UPDATE `user` SET
              `usr_email` = '$this->usr_email',
              `usr_password` = '$this->usr_password',
              `usr_type_id` = '$this->usr_type_id',
              `usr_created_datetime` = '$this->usr_created_datetime',
              `usr_email_verification_key` = '$this->usr_email_verification_key',
              `usr_email_verified` = '$this->usr_email_verified',
              `usr_verified_datetime` = '$this->usr_verified_datetime',
              `usr_role_id` = '$this->usr_role_id',
              `usr_password_reset_required` = '$this->usr_password_reset_required'
            WHERE
                `usr_id` = '$this->usr_id';";
    } ELSE {
    $sql = "
            INSERT INTO `user` (
              `usr_email`,
              `usr_password`,
              `usr_type_id`,
              `usr_created_datetime`,
              `usr_email_verification_key`,
              `usr_email_verified`,
              `usr_verified_datetime`,
              `usr_role_id`,
              `usr_password_reset_required`
    ) VALUES (
              '$this->usr_email',
              '$this->usr_password',
              '$this->usr_type_id',
              '$this->usr_created_datetime',
              '$this->usr_email_verification_key',
              '$this->usr_email_verified',
              '$this->usr_verified_datetime',
              '$this->usr_role_id',
              '$this->usr_password_reset_required'
    );";
    }
    $result = $GLOBALS['db']->execute($sql);
    $this->usr_id = (empty($this->usr_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->usr_id;
	
}

# end class	
}

?>