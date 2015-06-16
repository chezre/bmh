<?php 

require('inc/application.php');
require('inc/security.php');

$it = new extendedInTransfer();
$it->Load($_POST['trf_id']);
$oo = new extendedPetOwner();
$oo->LoadByUserId($it->trf_old_usr_id);
$no = new extendedPetOwner();
$no->LoadByUserId($it->trf_new_usr_id);
if ($_POST['decision']=='accepted') {
	$it->trf_accepted_date = date('Y-m-d H:i:s');
	$it->trf_rejected_date = null;
    $bodyTxt = preg_replace(array("/###name###/","/###newname###/"),array($oo->pow_first_name.' '.$oo->pow_last_name,$no->pow_first_name.' '.$no->pow_last_name),file_get_contents('emails/complete.transfer.accepted.txt'));
    $bodyHtml = preg_replace(array("/###name###/","/###newname###/"),array($oo->pow_first_name.' '.$oo->pow_last_name,$no->pow_first_name.' '.$no->pow_last_name),file_get_contents('emails/complete.transfer.accepted.htm'));
} else {
	$it->trf_accepted_date = null;
	$it->trf_rejected_date = date('Y-m-d H:i:s');
    $bodyTxt = preg_replace(array("/###name###/","/###newname###/"),array($oo->pow_first_name.' '.$oo->pow_last_name,$no->pow_first_name.' '.$no->pow_last_name),file_get_contents('emails/complete.transfer.rejected.txt'));
    $bodyHtml = preg_replace(array("/###name###/","/###newname###/"),array($oo->pow_first_name.' '.$oo->pow_last_name,$no->pow_first_name.' '.$no->pow_last_name),file_get_contents('emails/complete.transfer.rejected.htm'));
}
$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);
$it->Save();

$u = new extendUser();
$u->Load($it->trf_old_usr_id);

try {
	$mail = new extendedPhpmailer();
	$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
	$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	$mail->Subject = 'Pet Transfer Result';
	$mail->IsHTML();
	$mail->AltBody = $bodyTxt;
	$mail->MsgHTML($bodyHtml);
	
	$mail->AddAddress($u->usr_email,$u->usr_email);
	$result = $mail->sendEmail();
	} catch (phpmailerException $e) {
	# DO NOTHING
}

if ($_POST['decision']=='accepted') {
	$p = new extendedPet();
	$p->Load($it->trf_pet_id);
	$p->pet_usr_id = $it->trf_new_usr_id;
	$p->pet_status = 'ok';
	$p->Save();
}
header('location: '.$_SESSION['user']['landingPage']);

?>