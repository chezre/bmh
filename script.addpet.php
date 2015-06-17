<?php

# This script is for registering a pet owner to a pet

require('inc/application.php');
require('inc/security.php');

# Registering the pet
$p = new extendedPet();
$p->LoadByRFID($_POST['pet_rfid']);
$p->pet_usr_id = $_POST['pet_usr_id'];
$p->pet_assigned_by_usr_id = $_SESSION['user']['id'];
$p->pet_register_date = date("Y-m-d H:i:s");
$p->Save();

header('location:' . $_SESSION['user']['landingPage']);

?>