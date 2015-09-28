<?php 

require('inc/application.php');
require('inc/security.php');

if ($_SESSION['user']['roleId']!=1) {
	header('location:'.$_SESSION['user']['landingPage']);
	exit();
}


$u = new extendUser();
if (!$u->LoadByEmail($_GET['eml'])) {
	echo "no email address supplied";
	exit();
}
if (!empty($_GET['pwd'])) $u->setPassword($_GET['pwd']);
$u->usr_email = $_GET['eml'];
$u->setEmailVerificationKey($_GET['eml']);
$u->Save();

$p = new extendedPetOwner();
$p->LoadByUserId($u->usr_id);

###### send an email with this link:
$link = $_SERVER['SERVER_NAME']."/verify.php?k=".$u->usr_email_verification_key;

$bodyTxt = preg_replace(array("/###name###/","/###link###/"),array($p->pow_first_name.' '.$p->pow_last_name,$link),file_get_contents('emails/script.register.txt'));
$bodyHtml = preg_replace(array("/###name###/","/###link###/"),array($p->pow_first_name.' '.$p->pow_last_name,$link),file_get_contents('emails/script.register.htm'));
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
	$mail->AddAddress($_GET['eml'],$_GET['eml']);
	
	$result = $mail->sendEmail();
	
	if (!$result) {
		echo "message did not send failed.";
	} else {
		echo "message sent successfully";
		echo '<br /> go back to <a href="myadmin.php">admin page</a>';
	}
} catch (phpmailerException $e) {
	echo "message did not send failed.";
}

?>