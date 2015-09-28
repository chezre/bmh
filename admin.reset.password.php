<?php

require('inc/application.php');
require('inc/security.php');
if (!isset($_SESSION['user']['roleId'])||$_SESSION['user']['roleId']!=1) {
	if (isset($_SESSION['user']['landingPage'])) {
		header('location:'.$_SESSION['user']['landingPage']);
		exit();
	} else {
		header('location:index.php');
		exit();
	}
}

$password = $_POST['password'];
$newPassword = hash('sha256',strrev($password));

$u = new extendUser();
if ($u->LoadByEmail($_POST['email'])) {
	$u->usr_password = $newPassword;
	$u->usr_password_reset_required = (!empty($_POST['userMustReset'])) ? 'Y':'N';
	$u->Save();
	
	echo "Password has been reset";
} else {
	echo "Email does not exist";
}

?>