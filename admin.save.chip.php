<?php

require('inc/application.php');
require('inc/security.php');
require('inc/image.functions.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$pet = new extendedPet();
$pet->Load($_POST['pet_id']);
foreach($_POST as $k=>$v) $pet->$k=$v;

$pet->Save();
$result['request'] = $pet;
$result['message'] = 'Microchip details saved';

echo json_encode($result);