<?php 

require('inc/application.php');
require('inc/security.php');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

$p = new extendedPet();
if (!$p->Load($_POST['pet_id'])) {
	header('location: '.$_SESSION['user']['landingPage']);
	exit();
}

$u = new extendUser();
$userExists = $u->LoadByEmail($_POST['trfEmail']);
$tempPassword = '';
$name = 'NEW USER';
if (!$userExists) {
	$tempPassword = rand(11111111,99999999);
	$u->setPassword($tempPassword);	
	$u->usr_email = $_POST['trfEmail'];
	$u->usr_type_id = 1;
	$u->usr_email_verification_key = null;
	$u->usr_email_verified = 'Y';
	$u->usr_verified_datetime = date("Y-m-d H:i:s");
	$u->Save();
	
	$u->usr_password_reset_required = 'Y';
	$u->usr_role_id = 3;
	$u->Save();
	
	
	$bodyTxt = preg_replace(array("/###name###/","/###email###/","/###temporarypassword###/","/###rfid###/"),array($u->usr_email,$u->usr_email,$tempPassword,""),file_get_contents('emails/script.reset.login.txt'));
    $bodyHtml = preg_replace(array("/###name###/","/###email###/","/###temporarypassword###/","/###rfid###/"),array($u->usr_email,$u->usr_email,$tempPassword,""),file_get_contents('emails/script.reset.login.htm'));
	$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
	$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);
	
	try {
		$mail = new extendedPhpmailer();
		$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
		$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
		$mail->Subject = 'Password Reset';
		$mail->IsHTML();
		$mail->AltBody = $bodyTxt;
		$mail->MsgHTML($bodyHtml);
		
		$mail->AddAddress($_POST['trfEmail'],$_POST['trfEmail']);
		$result = $mail->sendEmail();
	} catch (phpmailerException $e) {
		# DO NOTHING
	}
} else {
    $o = new extendedPetOwner();
    if ($o->LoadByUserId($u->usr_id)) {
        $name = $o->pow_first_name . ' ' . $o->pow_last_name;
    } 
}

$it = new extendedInTransfer();
$it->trf_date = date("Y-m-d H:i:s");
$it->trf_old_usr_id = $p->pet_usr_id;
$it->trf_new_usr_id = $u->usr_id;
$it->trf_pet_id = $_POST['pet_id'];
$it->Save();

$p->pet_usr_id = null;
$p->pet_status = 'in transfer';
$p->Save();

$oo = new extendedPetOwner();
$oo->LoadByUserId($it->trf_old_usr_id);
	
$petAge = floor( (strtotime(date('Y-m-d')) - strtotime($p->pet_birthdate)) / 31556926);
$img = (empty($p->pet_photo_1)) ? '':'<img src="'.$p->pet_photo_1.'" style="float:left;margin-right: 10px;" width="120" height="90" />'; 
$bodyTxt = preg_replace(array("/###name###/","/###oldname###/","/###rfid###/","/###petname###/","/###petage###/"),array($name,$oo->pow_first_name.' '.$oo->pow_last_name,$p->pet_rfid,$p->pet_name,$petAge),file_get_contents('emails/transfer.pet.txt'));
$bodyHtml = preg_replace(array("/###name###/","/###oldname###/","/###rfid###/","/###petname###/","/###petage###/","/###img###/"),array($name,$oo->pow_first_name.' '.$oo->pow_last_name,$p->pet_rfid,$p->pet_name,$petAge,$img),file_get_contents('emails/transfer.pet.htm'));
$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);

try {
	$pmail = new extendedPhpmailer();
	$pmail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
	$pmail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	$pmail->Subject = 'Pet Transfer';
	$pmail->IsHTML();
	$pmail->AltBody = $bodyTxt;
	$pmail->MsgHTML($bodyHtml);
	
	$pmail->AddAddress($_POST['trfEmail'],$_POST['trfEmail']);
	$result = $pmail->sendEmail();
} catch (phpmailerException $e) {
	# DO NOTHING
}
header('location: '.$_SESSION['user']['landingPage'].'?r=success');

?>