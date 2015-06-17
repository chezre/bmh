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

$v = new extendedVet();
$v->Load($_POST['vet_id']);
$verified = (isset($_POST['vet_verified_by_admin'])&&$_POST['vet_verified_by_admin']=='Y'&&$v->vet_verified_by_admin!='Y');
foreach ($_POST as $k=>$val) $v->$k = $val;
$v->Save();

$u = new extendUser();
$u->Load($v->vet_usr_id);

if ($verified) { 
	###### send an email with this link:
    	$bodyTxt = preg_replace(array("/###name###/","/###email###/"),array($v->vet_name,$u->usr_email),file_get_contents('emails/script.save.vet.txt'));
    	$bodyHtml = preg_replace(array("/###name###/","/###email###/"),array($v->vet_name,$u->usr_email),file_get_contents('emails/script.save.vet.htm'));
		$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
		$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);
	
	try {
		$mail = new extendedPhpmailer();	
		$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
		$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
		$mail->Subject = 'Vet Registration confirmed';
		$mail->IsHTML();
		$mail->AltBody = $bodyTxt;
		$mail->MsgHTML($bodyHtml);
		$mail->AddAddress($u->usr_email,$v->vet_name);
		$result = $mail->sendEmail();
	} catch (phpmailerException $e) {
		# DO NOTHING
	}
}

header('location:'.$_SESSION['user']['landingPage']);

?>