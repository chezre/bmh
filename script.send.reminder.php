<?php 

require('inc/application.php');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

$ownersToBeReminded = $GLOBALS['fn']->getAllOwnersToBeReminded();
$logHeader = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reminder Email Log</title>
        <link rel="stylesheet" type="text/css" href="css/global.css" />
        <link rel="stylesheet" type="text/css" href="css/reminder.log.css" />
	</head>
	<body>
		<div id="mainDiv" style="overflow: auto;width: 1150px;">
			<div style="padding:20px;width: auto !important;text-align: center;">
                <img src="img/bmh_logo.png" width="265" height="86" />
				<hr />
            </div>
  
            <!-- start here -->
            <h3>Reminder Email Log</h3>
			<div id="lastRanDiv">Script last ran on '.date("Y-m-d H:i:s").'</div>
			<table width="95%" cellpadding="2" cellspacing="0">
				<tr>
					<th>date sent</th>
                    <th>result</th>
					<th>email</th>
					<th>chip number</th>
					<th>pet name</th>
					<th>vac date</th>
                    <th>vet</th>
                    <th>vet email</th>
				</tr>';
$login = (!empty($_SESSION['user']['landingPage'])) ? 'logout':'login';
$homePage = (!empty($_SESSION['user']['landingPage'])) ? $_SESSION['user']['landingPage']:'index.php';
$logFooter = '			</table>
            <div style="margin-left: 20px;margin-top: 20px;margin-bottom:20px;clear: both;">
				<a href="'.$login.'.php" style="color: inherit;font-weight: normal;font-size: 10pt;margin-top: 18px;">&gt; '.$login.'</a>
				<a href="'.$homePage.'" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; home</a>
			</div>
		</div>
	</body>
</html>';
$logRows = '';
if (empty($ownersToBeReminded)) {
	$logRows .= "\t\t\t\t".'<tr><td colspan="8">No reminders sent</td></tr>';	
} else {
	foreach ($ownersToBeReminded as $r) {
    
	    $bodyTxt = preg_replace(array("/###name###/","/###petname###/","/###vacdate###/"),array($r['name'],$r['pet_name'],$r['pet_next_vaccination_date']),file_get_contents('emails/script.send.reminder.txt'));
	    $bodyHtml = preg_replace(array("/###name###/","/###petname###/","/###vacdate###/"),array($r['name'],$r['pet_name'],$r['pet_next_vaccination_date']),file_get_contents('emails/script.send.reminder.htm'));
		$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
		$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);
	    
	    try {
		    $mail = new extendedPhpmailer();	
			$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
			$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
		    $mail->Subject = 'Vaccination Reminder - '.$r['pet_next_vaccination_date'];
		    $mail->IsHTML();
		    $mail->AltBody = $bodyTxt;
		    $mail->MsgHTML($bodyHtml);
		    
		    $v = new extendedVet();
		    $v->LoadByUserId($r['pet_next_vaccination_vet_usr_id']);
		    
		    $vetUser = new extendUser();
		    $vetUser->Load($r['pet_next_vaccination_vet_usr_id']);
		    
		    $mail->AddAddress($r['usr_email'],$r['name']);
		    $mail->AddCC($vetUser->usr_email,$v->vet_name);
		    $result = $mail->sendEmail();
		    $sendResult = 'Success';
	    } catch (phpmailerException $e) {
		    $sendResult = $e->errorMessage();
	    }
	    $logRows .= "\t\t\t\t".'<tr><td>'.date("Y-m-d H:i:s").'</td>';
	    $logRows .= '<td>'.$sendResult.'</td>';
	    $logRows .= '<td>'.$r['usr_email'].'</td>';
	    $logRows .= '<td>'.$r['pet_rfid'].'</td>';
	    $logRows .= '<td>'.$r['pet_name'].'</td>';
	    $logRows .= '<td>'.$r['pet_next_vaccination_date'].'</td>';
	    $logRows .= '<td>'.$v->vet_name.'</td>';
	    $logRows .= '<td>'.$vetUser->usr_email.'</td>';
	    $logRows .= '</tr>';
	    
	}	
}
	echo $logHeader.$logRows.$logFooter;

?>