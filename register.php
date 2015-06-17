<?php

require('inc/application.php');
session_start();

$homePage = 'index.php';
$navItem = '<li><a href="login.php">login</a></li>';	
if (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']=='Y') {
	$navItem = '<li><a href="logout.php">logout</a></li>';	
	$homePage = $_SESSION['user']['landingPage'];
	$isAdmin = ($_SESSION['user']['roleId'] == 1);
	if (!$isAdmin) {
		header('location: ' . $homePage);
		exit();
	}
}
$isSuperUser = (isset($_SESSION['user']['roleId'])&&$_SESSION['user']['roleId']!=1);


$showFailMessage = (isset($_GET['f'])&&$_GET['f']=='email') ? '':' style="display:none;"';
$currentPage = preg_replace("/\//",'',$_SERVER['SCRIPT_NAME']);
include('html/register.htm');

?>