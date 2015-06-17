<?php

require('inc/application.php');
require('inc/security.php');

$u = new extendUser();
$u->LoadByEmail($_POST['usr_email']);
$u->setPassword($_POST['usr_password']);
$u->usr_password_reset_required = 'N';
$u->Save();

$_SESSION['user']['isPasswordResetRequired'] = 'N';

if ($u->usr_type_id==1) {
	$pow = new extendedPetOwner();
	$pow->LoadByUserId($u->usr_id);
	if (empty($pow->pow_first_name)||empty($pow->pow_cellphone_no)) {
		header('location: edit.owner.php?o='.$u->usr_id);
		exit();
	}
}

header('location:'.$_SESSION['user']['landingPage']);

?>