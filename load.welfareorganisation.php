<?php 

require('inc/application.php');
require('inc/security.php');
if (!isset($_SESSION['user']['roleId'])||$_SESSION['user']['roleId']!=1) {
	header('location:index.php');
	exit();
}

$welId = (!isset($_POST['wel_id'])&&!empty($_POST['wel_id'])) ? $_POST['wel_id']:null;
$welId = (!empty($_GET['w'])) ? $_GET['w']:$welId;

$w = new extendedWelfareOrganisation();
if (!empty($welId)) {
	$w->Load($welId);
} else {
 	if (!isset($_POST['usr_id'])) {
		header('location:index.php');
		exit();
	}
	$w->LoadByUserId($_POST['usr_id']);
}
$u = new user();
$u->Load($w->wel_usr_id);

$isAdmin = ($_SESSION['user']['roleId']==1);
include('html/load.welfareorganisation.htm');

?>