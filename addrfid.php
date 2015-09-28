<?php

require('inc/application.php');
require('inc/security.php');

if (isset($_SESSION['user']['roleId'])) {
	if ($_SESSION['user']['roleId']==3) {
		header('location:mypets.php');
		exit();
	}
}

$homePage = 'index.php';	
if (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']=='Y') {
	$homePage = $_SESSION['user']['landingPage'];
}

$showFailMessage = (isset($_GET['f'])&&$_GET['f']=='email') ? '':' style="display:none;"';
include('html/addrfid.htm');

?>