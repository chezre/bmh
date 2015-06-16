<?php

require('inc/application.php');
require('inc/security.php');

if ($_SESSION['user']['isEmailVerified']=='N') {
	include('html/notVerified.htm');
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

if (!isset($_GET['p'])||empty($_GET['p'])) {
	header('location:index.php');
	exit();
}

$p = new extendedPet();
$p->Load($_GET['p']);

if ($p->pet_usr_id!=$_SESSION['user']['id']&&$_SESSION['user']['roleId']==3) {
	header('location:index.php');
	exit();
}

$usrId = $p->pet_usr_id;

$sexes = array('M','F');
$petSexOpts = '';
foreach ($sexes as $s) {
 	$selected = ($p->pet_sex==$s) ? ' SELECTED':'';
	$petSexOpts .= '<option value="'.$s.'"'.$selected.'>'.$s.'</option>';	
}

$steris = array('Y','N');
$steriOpts = '';
foreach ($steris as $s) {
	$selected = ($p->pet_sterilized==$s) ? ' SELECTED':'';
	$steriOpts .= '<option value="'.$s.'"'.$selected.'>'.$s.'</option>';
}

$species = $GLOBALS['fn']->getAllSpecies();
$speciesOpts = '';
foreach ($species as $s) {
	$selected = ($p->pet_species==$s['spe_description']) ? ' SELECTED':'';
	$speciesOpts .= '<option value="'.$s['spe_description'].'"'.$selected.'>'.$s['spe_description'].'</option>';
}

$petPhotos = '';
foreach (range(1,4) as $i) {
 	$imgKey = "pet_photo_$i";
 	$showImage = (!empty($p->$imgKey));
	$petPhotos .= $GLOBALS['fn']->populatePetImageForEdit($i,$p->$imgKey,$showImage);
}

$statusOpts = '';
$statuses = $GLOBALS['fn']->getPetStatuses();
foreach ($statuses as $k=>$v) {
 	if ($v['sta_description']=='in transfer') continue;
 	$selected = ($p->pet_status==$v['sta_description']) ? ' SELECTED':'';
	$statusOpts .= '<option value="'.$v['sta_description'].'"'.$selected.'>'.$v['sta_description'].'</option>';
}

$vetIdOpts = '<option value="">-- select --</option>';
if ($p->pet_assigned_by_usr_id==$_SESSION['user']['id']&&($_SESSION['user']['typeId']==1||$_SESSION['user']['typeId']==3)) {
	$vetIds = $GLOBALS['fn']->getInjectors();
	foreach ($vetIds as $k=>$v) {
		$selected = ($p->pet_assigned_by_usr_id==$v['usr_id']) ? ' SELECTED':'';
		$vetIdOpts .= '<option value="'.$v['usr_id'].'" title="'.$v['user_type'].'"'.$selected.'>'.$v['practice_name'].' (' . $v['name'];
		$vetIdOpts .= (empty($v['practice_no'])) ? '' : ' ' . $v['practice_no'];
		$vetIdOpts .= ')</option>';
	}
}

include('html/edit.pet.htm');

?>