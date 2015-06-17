<?php

include("inc/application.php");
include('inc/security.php');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
/*
$mail = new extendedPhpmailer();	
$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
$mail->Subject = 'Pet Owner Registration';
$mail->IsHTML();
$mail->AltBody = "Wasup?";
$mail->MsgHTML("<div>Wasup?</div>");
$mail->AddAddress("chezrefredericks@gmail.com","Chezre Fredericks");
$result = $mail->sendEmail();

if (!empty($GLOBALS['cfg']->KUSA->toAddresses)) {
	$mail->ClearAddresses();
	foreach ($GLOBALS['cfg']->KUSA->toAddresses->children() as $e) {
		$mail->AddAddress($e['email'],$e['name']);
	}
	$mail->sendEmail();
}*/

echo "<pre />";
print_r($_SESSION);