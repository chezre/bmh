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

$u = new extendUser();
if (!$u->LoadByEmail($_POST['email'])) {
	echo "no email address supplied";
	exit();
}
$u->setEmailVerificationKey($_POST['email']);
$u->Save();

$p = new extendedPetOwner();
$p->LoadByUserId($u->usr_id);

###### send an email with this link:
$link = $_SERVER['SERVER_NAME']."/verify.php?k=".$u->usr_email_verification_key;

$bodyTxt = preg_replace(array("/###name###/","/###link###/","/###regBy###/","/###regByEmail###/"),array($p->pow_first_name.' '.$p->pow_last_name,$link,"BringMeHome Admin","admin@bringmehome.co.za"),file_get_contents('emails/script.register.txt'));
$bodyHtml = preg_replace(array("/###name###/","/###link###/","/###regBy###/","/###regByEmail###/"),array($p->pow_first_name.' '.$p->pow_last_name,$link,"BringMeHome Admin","admin@bringmehome.co.za"),file_get_contents('emails/script.register.htm'));

$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);

try {
	$mail = new extendedPhpmailer();
	$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
	$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	$mail->Subject = 'Pet Owner Registration';
	$mail->IsHTML();
	$mail->AltBody = $bodyTxt;
	$mail->MsgHTML($bodyHtml);
	$mail->AddAddress($_POST['email'],$_POST['email']);
	
	$result = $mail->sendEmail();
	
	if (empty($result)||$result) {
		echo "message sent successfully";
	} else {
		echo "MESSAGE DID NOT GET SENT!";
	}
} catch (phpmailerException $e) {
	echo "an exception occured.";
}

?>