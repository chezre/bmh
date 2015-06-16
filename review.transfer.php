<?php

require('inc/application.php');
session_start();

if (!isset($_GET['t'])||empty($_GET['t'])) {
	if (isset($_SESSION['user']['isAuthenticated'])) {
		header('location:'.$_SESSION['user']['landingPage']);
		exit();
	} else {
		header('location:index.php');
		exit();
	}
}

$it = new intransfer();
$it->Load($_GET['t']);

$pet = new extendedPet();
$pet->Load($it->trf_pet_id);
 
$pow = new extendedPetOwner();
$pow->LoadByUserId($it->trf_old_usr_id);

$u = new extendUser();
$u->Load($pow->pow_usr_id);

$navItem = '<li><a href="login.php">login</a></li>';	
if (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']=='Y') {
	$navItem = '<li><a href="logout.php">logout</a></li>';	
}
$isOwnerOrAdmin = (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']=='Y'&&($_SESSION['user']['id']==$pet->pet_usr_id||$_SESSION['user']['roleId']!=3));

$nextVaccination = (empty($pet->pet_next_vaccination_date)) ? '--':$pet->pet_next_vaccination_date;
$history = $GLOBALS['fn']->getVaccinationHistory($pet->pet_id);
$historyRows = '<tr><td>No vaccination history</td></tr>';
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

include('html/review.pet.htm');

?>