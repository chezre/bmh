<?php 

require('inc/application.php');
require('inc/security.php');

if (!isset($_GET['p'])||empty($_GET['p'])) {
	if (isset($_SESSION['user']['isAuthenticated'])) {
		header('location:'.$_SESSION['user']['landingPage']);
		exit();
	} else {
		header('location:index.php');
		exit();
	}
}

if (isset($_SESSION['user']['id']) && $_SESSION['user']['id']>0) {
	$homePage = $_SESSION['user']['landingPage'];
} else {
	$homePage = 'index.php';
}

$canAddReport = (isset($_SESSION['user']['roleId'])&&$_SESSION['user']['roleId']!=3);

$petId = $_GET['p'];
$pet = new pet();
$pet->Load($petId);
$nextVaccination = (empty($pet->pet_next_vaccination_date)) ? '--':$pet->pet_next_vaccination_date;
$history = $GLOBALS['fn']->getVaccinationHistory($petId);
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

include('html/pet.history.htm');

?>