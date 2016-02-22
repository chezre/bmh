<?php

require('inc/application.php');
require('inc/security.php');

$pet = new extendedPet();
$pet->Load($_POST['pet_id']);

$pow = new extendedPetOwner();
$pow->LoadByUserId($pet->pet_usr_id);

$ownerAddress = $pow->pow_address_1;
if (!empty($ownerAddress)) $ownerAddress .= ', ';
$ownerAddress .= $pow->pow_address_2;
if (!empty($pow->pow_address_2)) $ownerAddress .= ', ';
$ownerAddress .= $pow->pow_address_3;


$u = new extendUser();
$u->Load($pow->pow_usr_id);

$injectedBy = $GLOBALS['fn']->getInjectorInfo($pet->pet_assigned_by_usr_id);

$margins = array(0,0,0,0);
ob_start();
include('html/certificate.htm');
$content = ob_get_clean();
$filename = 'certificates/'.$pet->pet_rfid.'-certification.pdf';
try
{
    $html2pdf = new HTML2PDF('P', 'A4', 'en',false,'ISO-8859-15',$margins);
    $html2pdf->setDefaultFont('frutiger');
    $html2pdf->writeHTML($content);
    $html2pdf->Output($filename,'F');
    
    $bodyTxt = preg_replace(array("/###name###/"),array($pow->pow_first_name . ' ' . $pow->pow_last_name),file_get_contents('emails/script.save.pet.txt'));
	$bodyHtml = preg_replace(array("/###name###/"),array($pow->pow_first_name . ' ' . $pow->pow_last_name),file_get_contents('emails/script.save.pet.htm'));
	$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
	$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);
	
	try {
		$mail = new extendedPhpmailer();
		$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
		$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
		$mail->AddCC($GLOBALS['cfg']->email->adminAddress['email'], $GLOBALS['cfg']->email->adminAddress['name']);
		$mail->Subject = 'Microchip Certificate';
		$mail->IsHTML();
		$mail->AltBody = $bodyTxt;
		$mail->MsgHTML($bodyHtml);	
		$mail->AddAddress($u->usr_email,$pow->pow_first_name . ' ' . $pow->pow_last_name);
		if (file_exists($filename)) $mail->AddAttachment($filename);
		$GLOBALS['cfg']->testing = 'N';
		$result = $mail->sendEmail();
		$GLOBALS['cfg']->testing = 'Y';
		
		# Send the KUSA mail
		if (!empty($GLOBALS['cfg']->KUSA->email)) {
			$mail->ClearAddresses();
			
			$bodyTxt = preg_replace(array("/###name###/"),array($GLOBALS['cfg']->KUSA->name),file_get_contents('emails/kusa.txt'));
			$bodyHtml = preg_replace(array("/###name###/"),array($GLOBALS['cfg']->KUSA->name),file_get_contents('emails/kusa.htm'));
			$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
			$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);
			
			$mail->AltBody = $bodyTxt;
			$mail->MsgHTML($bodyHtml);
            
            $mail->AddAddress($GLOBALS['cfg']->KUSA->email,$GLOBALS['cfg']->KUSA->name);

			$GLOBALS['cfg']->testing = 'N';
			$mail->sendEmail();
			$GLOBALS['cfg']->testing = 'Y';
		}
		
	} catch (phpmailerException $e) {
		# DO NOTHING
	}
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
$pet->pet_certificate_emailed = date("Y-m-d H:i:s");

	

$pet->Save();
$return['request'] = $pet;
$return['message'] = 'Email sent';

echo json_encode($return);