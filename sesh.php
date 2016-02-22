<?php

require('inc/application.php');
session_start();

if (empty($_SESSION['user']['isAuthenticated'])) {
	header('location:index.php');
	exit();
}


if (!empty($_SESSION)) {
	echo "<pre> \n";
	print_r($_SESSION);
	echo "</pre>";
} else {
	echo "not logged in<p>";
}

echo "<pre />";
print_r($GLOBALS['cfg']);

echo "<pre />";
print_r($GLOBALS['domain']);

?>