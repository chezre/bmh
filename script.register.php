<?php 

require('inc/application.php');

session_start();

$u = new extendUser();
if ($u->LoadByEmail($_POST['usr_email'])) {
	if (isset($_SESSION['user']['roleId']) && $_SESSION['user']['roleId']!=1) {
		header('location:load.owner.php?o='.$u->usr_id);
		exit();	
	} else {
		header('location:register.php?f=email');
		exit();
	}	
}
$u->setPassword($_POST['usr_password']);
$u->usr_email = $_POST['usr_email'];
$u->setEmailVerificationKey($_POST['usr_email']);
$u->usr_type_id = 1;

$t = new usertype();
$u->usr_role_id = ($t->Load($u->usr_type_id)) ? $t->uty_default_role_id : 3;
$u->Save();

$post = $_POST;
unset($post['usr_email'],$post['usr_password'],$post['usr_password_confirm']);

$p = new petowner();
$p->pow_usr_id = $u->usr_id;
foreach ($post as $k=>$v) $p->$k = $v;
$p->Save();

###### send an email with this link:
$link = "http://".$_SERVER['SERVER_NAME']."/verify.php?k=".$u->usr_email_verification_key;
$contactNo = (empty($p->pow_cellphone_no)) ? $p->pow_telephone_no:$p->pow_cellphone_no;
$bodyTxt = preg_replace(array("/###name###/","/###link###/","/###regBy###/","/###regByEmail###/"),array($p->pow_first_name.' '.$p->pow_last_name,$link,$p->pow_first_name.' '.$p->pow_last_name,$contactNo),file_get_contents('emails/script.register.txt'));
$bodyHtml = preg_replace(array("/###name###/","/###link###/","/###regBy###/","/###regByEmail###/"),array($p->pow_first_name.' '.$p->pow_last_name,$link,$p->pow_first_name.' '.$p->pow_last_name,$contactNo),file_get_contents('emails/script.register.htm'));
$bodyTxt = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyTxt);
$bodyHtml = preg_replace("/###domain###/", $GLOBALS['domain'], $bodyHtml);

try {
	$mail = new extendedPhpmailer();	
	$mail->SetFrom($GLOBALS['cfg']->email->fromAddress['email'], $GLOBALS['cfg']->email->fromAddress['name']);
	$mail->AddReplyTo($GLOBALS['cfg']->email->replyToAddress['email'], $GLOBALS['cfg']->email->replyToAddress['name']);
	$mail->Subject = 'Pet Owner Registration';
	$mail->IsHTML();
	$mail->AltBody = $bodyTxt;
	$mail->MsgHTML($bodyHtml);
	$mail->AddAddress($_POST['usr_email'],$_POST['usr_email']);
	$result = $mail->sendEmail();
} catch (phpmailerException $e) {
	# DO NOTHING
}
#####

if (!empty($_SESSION['user']['roleId'])) {
	header('location:load.owner.php?o='.$u->usr_id);
	exit();
}

header('location:registration.thankyou.php?uti=1');

?>