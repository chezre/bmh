<?php

require('inc/application.php');
session_start();

$passwordRequired = true;
if (isset($_SESSION['user']['roleId'])) {
	if ($_SESSION['user']['roleId']==3) {
		header('location:mypets.php');
		exit();				
	}
	$passwordRequired = false;
}

$homePage = '<a href="index.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; search</a>';
$navItem = '&nbsp;<a href="login.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; login</a>';	
if (!empty($_SESSION['user']['isAuthenticated'])) {
	$navItem = '<a href="logout.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; logout</a>';	
	$homePage = '&nbsp;<a href="'.$_SESSION['user']['landingPage'].'" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; home</a>';
}
$isSuperUser = (isset($_SESSION['user']['roleId'])&&$_SESSION['user']['roleId']!=1);

$showFailMessage = (isset($_GET['f'])&&$_GET['f']=='email') ? '':' style="display:none;"';
$currentPage = preg_replace("/\//",'',$_SERVER['SCRIPT_NAME']);
include('html/addwelfare.htm');

?>