<?php 

#  This script adds a welfare organisation and sends a registration email to the registee.

require('inc/application.php');
session_start();
$u = new extendUser();
if ($u->LoadByEmail($_POST['usr_email'])) {
 	header('location:addwelfare.php?f=email');	
 	exit();
}

$u->setPassword($_POST['usr_password']);
$u->usr_email = $_POST['usr_email'];
$u->setEmailVerificationKey($_POST['usr_email']);
$u->usr_type_id = 4;

$t = new usertype();
$u->usr_role_id = ($t->Load($u->usr_type_id)) ? $t->uty_default_role_id : 3;
$u->Save();

$post = $_POST;
unset($post['usr_email'],$post['usr_password'],$post['usr_password_confirm']);

$w = new extendedWelfareOrganisation();
$w->wel_usr_id = $u->usr_id;
foreach ($post as $k=>$v) $w->$k = $v;
$w->Save();
	
$link = "http://".$_SERVER['SERVER_NAME']."/verify.php?k=".$u->usr_email_verification_key;
$contactNo = (empty($w->wel_contact_mobile_number)) ? $w->wel_contact_number:$w->wel_contact_mobile_number;
$bodyTxt = preg_replace(array("/###name###/","/###link###/","/###regBy###/","/###regByEmail###/"),array($w->wel_name,$link,$w->wel_name,$contactNo),file_get_contents('emails/script.addvet.txt'));
$bodyHtml = preg_replace(array("/###name###/","/###link###/","/###regBy###/","/###regByEmail###/"),array($w->wel_name,$link,$w->wel_name,$contactNo),file_get_contents('emails/script.addvet.htm'));
$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);

try {
	$mail = new extendedPhpmailer();
	$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
	$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	$mail->AddCC($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	$mail->Subject = 'Welfare Organisation Registration';
	$mail->IsHTML();
	$mail->AltBody = $bodyTxt;
	$mail->MsgHTML($bodyHtml);
	$mail->AddAddress($_POST['usr_email'],$_POST['usr_email']);
	$result = $mail->sendEmail();
} catch (phpmailerException $e) {
	# DO NOTHING
}
#####
header('location:registration.thankyou.php');

?>