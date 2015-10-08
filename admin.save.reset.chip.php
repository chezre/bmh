<?php

require('inc/application.php');
require('inc/security.php');

$pet = new extendedPet();
$pet->LoadByRFID($_POST['pet_rfid']);

$result['request'] = $pet;
$result['message'] = $pet->ResetMicrochip();

echo json_encode($result);