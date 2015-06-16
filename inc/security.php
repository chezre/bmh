<?php 

session_start();

if (!isset($_SESSION['user']['isAuthenticated'])) {
	header('location:login.php');
	exit();
}

?>