<?php

require('inc/application.php');
require('inc/security.php');

$title = 'My Organisation';
$navItem = '<li><a href="logout.php">logout</a></li>';
$registerItem = '';
$isLoggedin = true;

$w = new extendedWelfareOrganisation();
$w->LoadByUserId($_SESSION['user']['id']);

if ($w->wel_verified_by_admin=='N') {
	include('html/notAdminVerified.htm');
	exit();
}

$resultMessage = '';
$resultDisplay = ' style="display:none"';
if (isset($_GET['r'])) {
	if ($_GET['r']=='rexists') $resultMessage = 'Error: Microchip number does not exist.';
	if ($_GET['r']=='success') $resultMessage = 'Microchip number sucessfully registered.';
	if ($_GET['r']=='rinuse') $resultMessage = 'Error: Microchip number already in use.';
	if ($_GET['r']=='notpo') $resultMessage = 'Error: Microchip number cannot be registered to a Welfare Organisation.';
	$resultDisplay = '';	
}

$isAdmin = ($_SESSION['user']['roleId']==1);
include('html/myorganisation.htm');

?>