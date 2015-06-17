<?php

#  This script is for when a Vet has registered his/her self

require('inc/application.php');
$u = new extendUser();
if ($u->LoadByEmail($_POST['usr_email'])) {
 	header('location:addvet.php?f=email');	
 	exit();
}

$u->usr_email = $_POST['usr_email'];
$u->usr_type_id = 2;
$u->usr_role_id = 2;
$u->Save();

$u->setPassword($_POST['usr_password']);	
$u->setEmailVerificationKey($_POST['usr_email']);
$u->usr_password_reset_required = 'N';
$u->Save();

$v = new extendedVet();
$v->vet_usr_id = $u->usr_id;
$v->vet_name = $_POST['vet_name'];
$v->vet_cellphone_no = $_POST['vet_cellphone_no'];
$v->vet_practice_no = $_POST['vet_practice_no'];
$v->vet_practice_name = $_POST['vet_practice_name'];
$v->vet_practice_address_1 = $_POST['vet_practice_address_1'];
$v->vet_practice_address_2 = $_POST['vet_practice_address_2'];
$v->vet_practice_address_3 = $_POST['vet_practice_address_3'];
$v->vet_practice_postal_code = $_POST['vet_practice_postal_code'];
$v->vet_practice_telephone_no = $_POST['vet_practice_telephone_no'];
$v->vet_practice_fax_no = $_POST['vet_practice_fax_no'];
$v->vet_statutory_id = $_POST['vet_statutory_id'];

$v->Save();

###### send an email with this link:
$link = "http://".$_SERVER['SERVER_NAME']."/verify.php?k=".$u->usr_email_verification_key;
$contactNo = (empty($v->vet_cellphone_no)) ? $v->vet_practice_telephone_no:$v->vet_cellphone_no;
$bodyTxt = preg_replace(array("/###name###/","/###link###/","/###regBy###/","/###regByEmail###/"),array($v->vet_name,$link,$v->vet_name,$contactNo),file_get_contents('emails/script.addvet.txt'));
$bodyHtml = preg_replace(array("/###name###/","/###link###/","/###regBy###/","/###regByEmail###/"),array($v->vet_name,$link,$v->vet_name,$contactNo),file_get_contents('emails/script.addvet.htm'));
$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);

try {
	$mail = new extendedPhpmailer();
	$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
	$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	$mail->AddCC($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	$mail->Subject = 'Verify Email';
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