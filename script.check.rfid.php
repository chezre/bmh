<?php

# This script is for checking if a pet exists
require('inc/application.php');
$p = new extendedPet();
$petExists = $p->LoadByRFID($_POST['pet_rfid']);

$rfid['exists'] = ($petExists) ? 'Y':'N';
$rfid['alreadyRegistered'] = (!empty($p->pet_usr_id)||!empty($p->pet_register_date)) ? 'Y':'N';

echo json_encode($rfid);

?>