<?php 

require('inc/application.php');
require('inc/security.php');
if (!isset($_SESSION['user']['roleId'])||$_SESSION['user']['roleId']!=1) {
	header('location:index.php');
	exit();
}

$vetId = (!isset($_POST['vet_id'])&&!empty($_POST['vet_id'])) ? $_POST['vet_id']:null;
$vetId = (!empty($_GET['v'])) ? $_GET['v']:$vetId;

$v = new extendedVet();
if (!empty($vetId)) {
	$v->Load($vetId);
} else {
 	if (!isset($_POST['usr_id'])) {
		header('location:index.php');
		exit();
	}
	$v->LoadByUserId($_POST['usr_id']);
}


$isAdmin = ($_SESSION['user']['roleId']==1);
include('html/load.vet.htm');

?>