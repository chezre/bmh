<?php 
	
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	require('class.pdo.php'); 
	
	#DAO
	require('DAO/class.user.php');
	require('DAO/class.usertype.php');
	require('DAO/class.userrole.php');
	require('DAO/class.pet.php');
	require('DAO/class.petowner.php');
	require('DAO/class.vaccinationhistory.php');
	require('DAO/class.vet.php');	
	require('DAO/class.welfareorganisation.php');
	require('DAO/class.intransfer.php');
	require('DAO/class.adminstaff.php');
			
	#DAO extensions
	require('DAO/class.user.extension.php');
	require('DAO/class.petowner.extension.php');
	require('DAO/class.pet.extension.php');
	require('DAO/class.vet.extension.php');
	require('DAO/class.welfareorganisation.extension.php');
	require('DAO/class.intransfer.extension.php');
	require('DAO/class.adminstaff.extension.php');
	
	#pdf class
	require('html2pdf.class.php');
	
	#email
	require('class.phpmailer.php');
	require('class.phpmailer.extension.php');
	require('class.smtp.php');
	
	#functions
	require('class.functions.php');
	
	$dbconnection = simplexml_load_file("inc/DAO/dbconnection.xml");
	$m = new pdo_functions;
	$m->host = (string)$dbconnection->host;
	$m->user = (string)$dbconnection->username;
	$m->password = (string)$dbconnection->password;
	$m->database = (string)$dbconnection->database;
	$m->connect();
	
	$config = simplexml_load_file("inc/conf.xml");
	$GLOBALS['db'] = $m;
	$GLOBALS['fn'] = new functions();
	$GLOBALS['cfg'] = $config;
	$GLOBALS['domain'] = $_SERVER['SERVER_NAME'];

?>