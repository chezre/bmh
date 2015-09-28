<?php 

require('inc/application.php');
require('inc/security.php');

$u = new extendUser();
if ($u->LoadByEmail($_POST['usr_email'])) {
	$post = $_POST;
	unset($post['usr_email'],$post['usr_password'],$post['usr_password_confirm']);
	
	$p = new extendedPetowner();
	if (!$p->LoadByUserId($u->usr_id)) $p->pow_usr_id = $u->usr_id;
	foreach ($post as $k=>$v) $p->$k = $v;
	
	$p->Save();	

}

header('location:load.owner.php?o='.$u->usr_id);

?>