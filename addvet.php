<?php 

require('inc/application.php');
session_start();
$currentPage = preg_replace("/\//",'',$_SERVER['SCRIPT_NAME']);
$homePage = '<a href="index.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; search</a>';
$navItem = '&nbsp;<a href="login.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; login</a>';	
if (!empty($_SESSION['user']['isAuthenticated'])) {
	$navItem = '<a href="logout.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; logout</a>';	
	$homePage = '&nbsp;<a href="'.$_SESSION['user']['landingPage'].'" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; home</a>';
}
$showFailMessage = (isset($_GET['f'])&&$_GET['f']=='email') ? '':' style="display:none;"';
include('html/addvet.htm');

?>