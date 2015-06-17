<?php

require('inc/application.php');
require('inc/security.php');
if (!isset($_SESSION['user']['roleId'])||$_SESSION['user']['roleId']!=1) {
	if (isset($_SESSION['user']['landingPage'])) {
		header('location:'.$_SESSION['user']['landingPage']);
		exit();
	} else {
		header('location:index.php');
		exit();
	}
}

$p = new extendedPet();
$p->LoadByRFID($_GET['rfid']);

$return['message'] = (!empty($p->pet_id)) ? 'Cool Beans':'RFID not found.';
if (!empty($p->pet_id)&&empty($p->pet_usr_id)) $return['message'] = 'This Microchip is not linked to any Pet Owner';
$return['error'] = (empty($p->pet_id)||empty($p->pet_usr_id)) ? 'Y':'N';
$return['pet_id'] = $p->pet_id;
$return['pow_usr_id'] = $p->pet_usr_id;
$return['rfid'] = $p->pet_rfid;
$return['status'] = (!empty($p->pet_certificate_emailed)) ? 'complete':'incomplete';
$return['click'] = '';

$o = new extendedPetOwner();
$o->LoadByUserId($p->pet_usr_id);

if (
	(empty($o->pow_first_name)&&empty($o->pow_last_name))
	||(empty($o->pow_address_1)&&empty($o->pow_address_2)&&empty($o->pow_address_3))
	||(empty($o->pow_postal_code))
	||(empty($o->pow_cellphone_no)&&empty($o->pow_telephone_no))
   ) {
	   $return['click'] = 'liStep1';
	   $return['srcStep1'] = 'no';
	} else {
		$return['srcStep1'] = 'yes';
	}

if (empty($p->pet_name)||empty($p->pet_birthdate)
	||empty($p->pet_species)
	||empty($p->pet_breed)
	||empty($p->pet_sex)
	||empty($p->pet_colour)
   ) {
   if (empty($return['click'])) $return['click'] = 'liStep2';
   $return['srcStep2'] = 'no';
} else {
   $return['srcStep2'] = 'yes';
}

if (!empty($p->pet_certificate_emailed)) {
    $return['srcStep3'] = 'yes';
} else {
   if (empty($return['click'])) $return['click'] = 'liStep3';
   $return['srcStep3'] = 'no';
}

echo json_encode($return);