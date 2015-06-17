<?php 

require('inc/application.php');

$u = new extendUser();
if ($u->LoadByEmail($_POST['usr_email'])) {
	$tempPassword = rand(11111111,99999999);
	$u->setPassword($tempPassword);	
	$u->usr_password_reset_required = 'Y';
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
		$mail->AddAddress($_POST['usr_email'],$_POST['usr_email']);
		$result = $mail->sendEmail();
	} catch (phpmailerException $e) {
		# DO NOTHING
	}
	header('location:login.php');
} else {
 	include('html/reset.login.failed.htm');
}

?>