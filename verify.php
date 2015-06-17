<?php

require('inc/application.php');

if (!isset($_GET['k'])) {
	header('location:index.php');
	exit();
}

$u = new extendUser();
$verified = $u->verifyEmail($_GET['k']);
if ($verified) {
    
    $o = new extendedPetOwner();
    if ($o->LoadByUserId($u->usr_id)) {
        $verifyResult = 'Thank you ' . $o->pow_first_name . ' ' . $o->pow_last_name.'.<br />';
        $name = $o->pow_first_name . ' ' . $o->pow_last_name; 
        
        $bodyTxt = preg_replace(array("/###name###/"),array($name),file_get_contents('emails/verify.txt'));
        $bodyHtml = preg_replace(array("/###name###/"),array($name),file_get_contents('emails/verify.htm'));
		$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
		$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);
		
        try {
	        $mail = new extendedPhpmailer();
			$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
			$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	        $mail->Subject = 'Verification Successful';
	        $mail->IsHTML();
	        $mail->AltBody = $bodyTxt;
	        $mail->MsgHTML($bodyHtml);
	        
	        $mail->AddAddress($u->usr_email,$u->usr_email);
	        $result = $mail->sendEmail();
        } catch (phpmailerException $e) {
		# DO NOTHING
	}
    }
    
    $v = new extendedVet();
    if ($v->LoadByUserId($u->usr_id)) {
       $verifyResult = 'Thank you ' .$v->vet_name.'.<br />';
    }
    
    $w = new extendedWelfareOrganisation();
    if ($w->LoadByUserId($u->usr_id)) {
       $verifyResult = 'Thank you ' .$w->wel_contact_fullname.'.<br />';
    }
    $verifyResult .= 'Your email address ('.$u->usr_email.') was successfully verified.';
} else {
	$verifyResult = 'Sorry, your verification key was incorrect.  Please click on the link provided in your verification email.';
}

include('html/verify.htm');

?>