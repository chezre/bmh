<?php

require('inc/application.php');
session_start();

$navItem = '<li><a href="login.php">login</a></li>';	
$registerItem = '<li><a href="addvet.php">register</a></li>';
$isLoggedin = false;
if (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']=='Y') {
	$navItem = '<li><a href="logout.php">logout</a></li>';	
	$isLoggedin = true;
	$registerItem = '';
}
if ($isLoggedin&&$_SESSION['user']['detailsTable']=='vet') {
	header('location:mypractice.php');
	exit();
}
$title = "BringMeHome";
include('html/index.htm');

?>