<?php

require('inc/application.php');
session_start();

if (isset($_SESSION['user']['isPasswordResetRequired'])&&$_SESSION['user']['isPasswordResetRequired'] =='Y') {
	header('location:reset.password.php');
	exit();
}

if (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']) {
	header('location:'.$_SESSION['user']['landingPage']);
	exit();
}

#	Check for failure message
$showFailMessage = (isset($_GET['f'])&&$_GET['f']=='y') ? '' : ' style="display: none"';

#	Load template
include('html/login.htm');	

?>