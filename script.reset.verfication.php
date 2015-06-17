<?php 

require('inc/application.php');
session_start();



$u = new extendUser();
$u->usr_email = $_SESSION['user']['email'];
$u->setEmailVerificationKey($_SESSION['user']['email']);

###### send an email with this link:
echo "http://www.bringmehome.co.za/verify.php?k=".$u->usr_email_verification_key;


?>