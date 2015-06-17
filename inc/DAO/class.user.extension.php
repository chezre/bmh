<?php

Class extendUser extends user { 
 	
 	var $isAuthenticated;
 	
	function checkPassword() {
	 	if (empty($this->usr_email)||$this->usr_email==''||is_null($this->usr_email)
		 ||strlen($this->usr_email)==0) $this->isAuthenticated = false;
	 	if (empty($this->usr_password)||$this->usr_password==''||is_null($this->usr_password)
		 ||strlen($this->usr_password)==0) $this->isAuthenticated = false;
		$sql = "SELECT `usr_id` FROM `user` WHERE `usr_email` = '".$this->usr_email;
		$sql .= "' AND `usr_password` = '".$this->usr_password."';";
		
        $result = $GLOBALS['db']->select($sql);
		if (!$result||empty($result)) {
	    	$this->isAuthenticated = false;
	    } else {
	     	if ($result[0]['usr_id']>0) {
				$this->Load($result[0]['usr_id']);
				$this->isAuthenticated = true;	
			}
		}	
	}
	
	function setPassword($password) {
	 	$this->usr_password = hash('sha256',strrev($password));
		return $this->usr_password;
	}
	
	function setEmailVerificationKey($email) {
		$this->usr_email_verification_key = hash('sha256',strrev($email.rand()));
		return $this->usr_email_verification_key;
	}
	
	function verifyEmail($key) {
		$sql = "SELECT * FROM `user` where `usr_email_verification_key` = '".trim($key)."'";
		$result = $GLOBALS['db']->select($sql);
		if (!empty($result)) {
		 	foreach ($result[0] as $k => $v) $this->$k = stripslashes($v);
	    	$this->usr_email_verified = 'Y';
	    	$this->usr_verified_datetime = date("Y-m-d H:i:s");
	    	$this->usr_email_verification_key = null;
	    	$this->Save();
	    	return true;
	    } else {
			return false;
		}
	}
	
	function LoadByEmail($email) {
		if (empty($email)) return false;
		$sql = "SELECT * FROM `user` where `usr_email` = '".trim($email)."'";
		$result = $GLOBALS['db']->select($sql);
		if (!empty($result)) {
		 	foreach ($result[0] as $k => $v) $this->$k = stripslashes($v);
	    	return true;
	    } else {
			return false;
		}
	}
	
	function Save() {
	
		if (isset($this->usr_id) && !empty($this->usr_id)) {
		$sql = "
	            UPDATE `user` SET
	              `usr_email` = '$this->usr_email',
	              `usr_password` = '$this->usr_password',
	              `usr_type_id` = '$this->usr_type_id',
	              `usr_email_verification_key` = ";
		$sql .= (empty($this->usr_email_verification_key)) ? "null":"'$this->usr_email_verification_key'";
		$sql .= ",
	              `usr_email_verified` = '$this->usr_email_verified',
	              `usr_verified_datetime` = ";
		$sql .=	(empty($this->usr_verified_datetime)) ? "null":"'$this->usr_verified_datetime'";
		$sql .= ",
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
	              `usr_email_verification_key`,
	              `usr_role_id`
	    ) VALUES (
	              '$this->usr_email',
	              '$this->usr_password',
	              '$this->usr_type_id',
	              '$this->usr_email_verification_key',
	              '$this->usr_role_id'
	    );";
	    }
	    $result = $GLOBALS['db']->execute($sql);
	    $this->usr_id = (empty($this->usr_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->usr_id;
		
	}
}

?>