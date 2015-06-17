<?php

require('inc/application.php');
require('inc/security.php');

$r = new vaccinationhistory();
$r->vhi_usr_id = $_SESSION['user']['id'];
foreach ($_POST as $k=>$v) $r->$k = $v;
$r->Save();

$p = new extendedPet();
$p->Load($_POST['vhi_pet_id']);
$p->pet_next_vaccination_date = (!empty($_POST['pet_next_vaccination_date'])) ? $_POST['pet_next_vaccination_date']:$p->pet_next_vaccination_date;
$p->Save();

$o = new extendedPetOwner();
$o->LoadByUserId($p->pet_usr_id);

$u = new extendUser();
$u->Load($p->pet_usr_id);

$v = new extendedVet();
if ($v->LoadByUserId($_SESSION['user']['id'])) {
	$superusername = $v->vet_name;
}  

$su = new extendedAdminStaff();
if ($su->LoadByUserId($_SESSION['user']['id'])) {
	$superusername = $su->adm_name;
}

$w = new extendedWelfareOrganisation();
if ($w->LoadByUserId($_SESSION['user']['id'])) {
	$superusername = $w->wel_name;
}

$bodyTxt = preg_replace(array("/###name###/","/###superuser###/","/###petname###/"),array($o->pow_first_name.' '.$o->pow_last_name,$superusername,$p->pet_name),file_get_contents('emails/script.addreport.txt'));
$bodyHtml = preg_replace(array("/###name###/","/###superuser###/","/###petname###/"),array($o->pow_first_name.' '.$o->pow_last_name,$superusername,$p->pet_name),file_get_contents('emails/script.addreport.htm'));
$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);

try {
	$mail = new extendedPhpmailer();
	$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
	$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	$mail->Subject = 'Vaccination Added';
	$mail->IsHTML();
	$mail->AltBody = $bodyTxt;
	$mail->MsgHTML($bodyHtml);
	
	$mail->AddAddress($u->usr_email,$o->pow_first_name.' '.$o->pow_last_name);
	$result = $mail->sendEmail();
} catch (phpmailerException $e) {
	# DO NOTHING
}

header('location:load.pet.php?p='.$p->pet_id);

?>