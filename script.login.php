<?php 

require('inc/application.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$u = new extendUser();
$u->setPassword($_POST['usr_password']);
$u->usr_email = $_POST['usr_email'];
$u->checkPassword();

if ($u->isAuthenticated) {
 	
 	session_start();
 	$_SESSION['user']['email'] = $u->usr_email;
 	$_SESSION['user']['isAuthenticated'] = $u->isAuthenticated;
 	$_SESSION['user']['isEmailVerified'] = $u->usr_email_verified;
 	$_SESSION['user']['isPasswordResetRequired'] = $u->usr_password_reset_required;
 	$_SESSION['user']['id'] = $u->usr_id; 
 	
	$ut = new usertype();
	$ut->Load($u->usr_type_id);
	$_SESSION['user']['landingPage'] = $ut->uty_landing_page;
	$_SESSION['user']['detailsTable'] = $ut->uty_table;
	$_SESSION['user']['typeId'] = $u->usr_type_id;
	
	$ur = new userrole();	
	$ur->Load($u->usr_role_id);
	$_SESSION['user']['role'] = $ur->rol_description;
	$_SESSION['user']['roleId'] = $ur->rol_id;
	
	if ($_SESSION['user']['isPasswordResetRequired'] =='Y') {
	 	header('location:reset.password.php');
		exit();
	} 
	
	if ($u->usr_type_id==1) {
		$pow = new extendedPetOwner();
		$pow->LoadByUserId($u->usr_id);
		if (empty($pow->pow_first_name)||(empty($pow->pow_cellphone_no)&&empty($pow->pow_telephone_no))) {
			header('location: edit.owner.php?o='.$u->usr_id);
			exit();
		}
	}
	
	header('location:'.$ut->uty_landing_page);	
	exit();
} else {
	header('location:login.php?f=y');
	exit();
}

?>