<?php

require('inc/application.php');

if (!isset($_POST['pet_id'])) {
	header('location:mypractice.php');
	exit();
}

session_start();
if (isset($_SESSION['user']['id']) && $_SESSION['user']['id']>0) {
	$homePage = $_SESSION['user']['landingPage'];
} else {
	$homePage = 'index.php';
}

$p = new pet();
$p->Load($_POST['pet_id']);
$imgs = '';
foreach (range(1,4) as $i) {
	$photo = 'pet_photo_'.$i;
	if (!empty($p->$photo)) $imgs .= '<img src="'.$p->$photo.'" width="32" height="24" class="thumbNails" onclick="showImage(this,\'img-'.$p->pet_rfid.'\')" />';
}

$title = "My Practice";

$vacOpts= '<option value="">-- select --</option>';
$vacGroup = '';
$vaccinations = $GLOBALS['fn']->getVaccinationsForPet($p->pet_species);

if (!empty($vaccinations)) {
	foreach ($vaccinations as $k=>$v) {
		#$vacOpts.= ($vacGroup!=$v['vac_grouping']) ? '<optgroup style="color: #000044;background-color: #C0C0C0;">'.$v['vac_grouping'].'</optgroup>':'';
		$vacGroup = $v['vac_grouping'];
		$vacOpts.= '<option value="'.$v['vac_description'].'">'.$v['vac_description'].'</option>';
	}
}

$petAge = floor( (strtotime(date('Y-m-d')) - strtotime($p->pet_birthdate)) / 31556926);
$notes = (empty($pet->pet_general_notes)) ? '&nbsp;':$p->pet_general_notes;
$features = (empty($p->pet_distinguishing_features)) ? '&nbsp;':$p->pet_distinguishing_features;

include('html/addreport.htm');

?>