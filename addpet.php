<?php

header('location:index.php');
exit();

######  Not necessary anymore

require('inc/application.php');
require('inc/security.php');

if ($_SESSION['user']['isEmailVerified']=='N') {
	echo "You need to verify your email address before you can use this site";
	exit();
}

if (isset($_SESSION['user']['isPasswordResetRequired'])&&$_SESSION['user']['isPasswordResetRequired'] =='Y') {
	header('location:reset.password.php');
	exit();
}
if (isset($_SESSION['user']['id']) && $_SESSION['user']['id']>0) {
	$homePage = $_SESSION['user']['landingPage'];
} else {
	$homePage = 'index.php';
}
$usrId = (isset($_POST['pet_usr_id'])&&$_POST['pet_usr_id']>0) ? $_POST['pet_usr_id']:$_SESSION['user']['id'];

$species = $GLOBALS['fn']->getAllSpecies();
$speciesOpts = '';
foreach ($species as $s) {
	$speciesOpts .= '<option value="'.$s['spe_description'].'">'.$s['spe_description'].'</option>';
}

include('html/addpet.htm');
?>