<?php 

require('inc/application.php');
require('inc/security.php');

$p = new extendedPet();
if (!$p->LoadByRFID($_POST['pet_rfid'])) {
	header('location: '.$_SESSION['user']['landingPage'].'?r=rexists');
	exit();
}

if (!empty($p->pet_usr_id)) {
    header('location: '.$_SESSION['user']['landingPage'].'?r=rinuse');
	exit();
}

# Register User if not already registered
$u = new extendUser();
$userExists = $u->LoadByEmail($_POST['usr_email']);
if ($userExists&&$u->usr_type_id!=1) {
	header('location: '.$_SESSION['user']['landingPage'].'?r=notpo');
	exit();
}


$tempPassword = '';
if (!$userExists) {
	$tempPassword = rand(11111111,99999999);
	$u->setPassword($tempPassword);	
	$u->usr_email = $_POST['usr_email'];
	$u->usr_type_id = 1;
	$u->usr_email_verification_key = null;
	$u->usr_email_verified = 'Y';
	$u->usr_verified_datetime = date("Y-m-d H:i:s");
	$u->Save();
	
	$u->usr_password_reset_required = 'Y';
	$u->usr_role_id = 3;
	$u->Save();
	
	$rfid_text = "Microchip " . $p->pet_rfid . " has been linked to your email address.";
	$find = array("/###name###/","/###email###/","/###temporarypassword###/","/###domain###/","/###rfid###/");
	$replacements = array($u->usr_email,$u->usr_email,$tempPassword,$GLOBALS['domain'],$rfid_text);
	
	$bodyTxt = preg_replace($find,$replacements,file_get_contents('emails/script.reset.login.txt'));
    $bodyHtml = preg_replace($find,$replacements,file_get_contents('emails/script.reset.login.htm'));
	
	try {
		$mail = new extendedPhpmailer();
		$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
		$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
		$mail->Subject = 'Password Reset';
		$mail->IsHTML();
		$mail->AltBody = $bodyTxt;
		$mail->MsgHTML($bodyHtml);	
		$mail->AddAddress($_POST['usr_email'],$_POST['usr_email']);
		$result = $mail->sendEmail();
	} catch (phpmailerException $e) {
		# DO NOTHING
	}
}

# Registering the pet
$p->pet_usr_id = $u->usr_id;
$p->pet_name = $_POST['pet_name'];
$p->pet_assigned_by_usr_id = $_SESSION['user']['id'];
$p->pet_register_date = date("Y-m-d H:i:s");
$p->Save();

$assignedDetails = $GLOBALS['fn']->getInjectorInfo($_SESSION['user']['id']);

$bodyTxt = preg_replace(array("/###rfid###/","/###regBy###/","/###regByEmail###/"),array($p->pet_rfid,$assignedDetails['name'],$_SESSION['user']['email']),file_get_contents('emails/script.rfid.txt'));
$bodyHtml = preg_replace(array("/###rfid###/","/###regBy###/","/###regByEmail###/"),array($p->pet_rfid,$assignedDetails['name'],$_SESSION['user']['email']),file_get_contents('emails/script.rfid.htm'));
$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);

try {
	$pmail = new extendedPhpmailer();
	$pmail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
	$pmail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	$pmail->Subject = 'New Pet Registered';
	$pmail->IsHTML();
	$pmail->AltBody = $bodyTxt;
	$pmail->MsgHTML($bodyHtml);
	$pmail->AddAddress($_POST['usr_email'],$_POST['usr_email']);
	$result = $pmail->sendEmail();
} catch (phpmailerException $e) {
	# DO NOTHING
}

header('location: '.$_SESSION['user']['landingPage'].'?r=success');

?>