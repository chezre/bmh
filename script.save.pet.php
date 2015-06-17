<?php

require('inc/application.php');
require('inc/security.php');
require('inc/image.functions.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$pet = new extendedPet();
$pet->Load($_POST['pet_id']);
foreach($_POST as $k=>$v) $pet->$k=$v;

if (!empty($_FILES)) {
 	for ($i=1;$i<=4;$i++) {
 	 	$f = "pet_photo_$i";
 	 	if ($_FILES[$f]['error']<1) {
			$pet->$f = moveUploadedFile($_FILES[$f],$pet->pet_rfid.'-'.$i);
		}
	}	
}

$pet->Save();

if ($_SESSION['user']['id']==$pet->pet_usr_id) {
	header('location:load.pet.php?p='.$pet->pet_id);
	exit();
} else {
	header('location:'.$_SESSION['user']['landingPage']);	
}

?>