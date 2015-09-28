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

$newVetRows = '<tr><td colspan="4">No new vets have registered</td></tr>';
$newVets = $GLOBALS['fn']->getNewVets();
if (!empty($newVets)) {
	$newVetRows = '';
	foreach ($newVets as $v) {
		$newVetRows .= '<tr onclick="loadUser('.$v['usr_id'].',\''.preg_replace('/ /','',strtolower($v['user_type'])).'\')" class="vetRow">';
		$newVetRows .= '<td>'.$v['user_type'].'</td>';
		$newVetRows .= '<td>'.$v['name'].'</td>';
		$newVetRows .= '<td>'.$v['email'].'</td>';
		$newVetRows .= '<td>'.$v['cellphone'].'</td>';
		$newVetRows .= '<td>'.$v['registration_date'].'</td>';
		$newVetRows .= '</tr>';								
	}
}

$showSuccessImportResult = (isset($_GET['r'])&&!empty($_GET['r'])&&$_GET['r']=='risuccess') ? '':'display: none;';
$showFailedImportResult = (isset($_GET['r'])&&!empty($_GET['r'])&&$_GET['r']=='rifailed') ? '':'display: none;';
$importedRecordCount = (isset($_GET['c'])&&!empty($_GET['c'])) ? $_GET['c']:0;
include('html/myadmin.htm');

?>