<?php 

require('inc/application.php');
require('inc/security.php');

$post = $_POST;

$w = new extendedWelfareOrganisation();
$w->Load($_POST['wel_id']);
$verified = (isset($_POST['wel_verified_by_admin'])&&$_POST['wel_verified_by_admin']=='Y'&&$w->wel_verified_by_admin!='Y');
foreach ($post as $k=>$v) $w->$k = $v;
$w->Save();

$u = new extendUser();
$u->Load($w->wel_usr_id);

if ($verified) { 
	###### send an email with this link:
	$bodyTxt = preg_replace(array("/###name###/","/###email###/"),array($w->wel_contact_fullname,$u->usr_email),file_get_contents('emails/script.save.welfare.txt'));
    $bodyHtml = preg_replace(array("/###name###/","/###email###/"),array($w->wel_contact_fullname,$u->usr_email),file_get_contents('emails/script.save.welfare.htm'));
	$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
	$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);
	
	try {
		$mail = new extendedPhpmailer();	
		$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
		$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
		$mail->Subject = 'Registration confirmed';
		$mail->IsHTML();
		$mail->AltBody = $bodyTxt;
		$mail->MsgHTML($bodyHtml);
		$mail->AddAddress($u->usr_email,$u->usr_email);
		$result = $mail->sendEmail();
	} catch (phpmailerException $e) {
		# DO NOTHING
	}
}

header('location:'.$_SESSION['user']['landingPage']);

?>