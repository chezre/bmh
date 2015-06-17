<?php

require('inc/application.php');
session_start();

if (!isset($_GET['p'])||empty($_GET['p'])) {
	if (isset($_SESSION['user']['isAuthenticated'])) {
		header('location:'.$_SESSION['user']['landingPage']);
		exit();
	} else {
		header('location:index.php');
		exit();
	}
}

$pet = new extendedPet();
$pet->Load($_GET['p']);
$imgs = '';
foreach (range(1,4) as $i) {
	$photo = 'pet_photo_'.$i;
	if (!empty($pet->$photo)) $imgs .= '<img src="'.$pet->$photo.'" width="32" height="24" class="thumbNails" onclick="showImage(this,\'img-'.$pet->pet_rfid.'\')" />';
}
 
$pow = new extendedPetOwner();
if (!$pow->LoadByUserId($pet->pet_usr_id)) {
	$errorMsg = 'This was an error loading this pet&apos;s owner.  Please contact the BringMeHome administrator on 021 556 0003.';
	include("html/error.htm");
	exit();
}

$u = new extendUser();
if (!$u->Load($pow->pow_usr_id)) {
	$errorMsg = 'This was an error loading this pet&apos;s owner.  Please contact the BringMeHome administrator on 021 556 0003.';
	include("html/error.htm");
	exit();
}

$navItem = '<li><a href="login.php">login</a></li>';	
if (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']=='Y') {
	$navItem = '<li><a href="logout.php">logout</a></li>';	
}
$isOwnerOrAdmin = (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']=='Y'&&($_SESSION['user']['id']==$pet->pet_usr_id||$_SESSION['user']['roleId']==1));

$isOwner = (!empty($_SESSION['user']['isAuthenticated'])&&($_SESSION['user']['id']==$pet->pet_usr_id));

$isSuperUser = (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']=='Y'&&$_SESSION['user']['roleId']==2);

$nextVaccination = (empty($pet->pet_next_vaccination_date)) ? '--':$pet->pet_next_vaccination_date;
$history = $GLOBALS['fn']->getVaccinationHistory($pet->pet_id);
$historyRows = '<tr><td colspan="4">No vaccination history</td></tr>';
If (!empty($history)) {
 	$historyRows = '';
	foreach ($history as $h) {
		$historyRows .= '<tr><td>'.$h['vhi_date'].'</td>';
		$historyRows .= '<td>'.$h['vhi_name'].'</td>';
		$historyRows .= '<td>'.$h['vhi_batch_no'].'</td>';
		$historyRows .= '<td>'.$h['vhi_note'].'</td>';
		$historyRows .= '</tr>';
	}
}

$petAge = floor( (strtotime(date('Y-m-d')) - strtotime($pet->pet_birthdate)) / 31556926);
$notes = (empty($pet->pet_general_notes)) ? '&nbsp;':$pet->pet_general_notes;
$features = (empty($pet->pet_distinguishing_features)) ? '&nbsp;':$pet->pet_distinguishing_features;

$canAddReport = (isset($_SESSION['user']['roleId'])&&$_SESSION['user']['roleId']!=3);

include('html/load.pet.htm');

?>