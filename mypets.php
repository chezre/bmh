<?php

require('inc/application.php');
require('inc/security.php');

if ($_SESSION['user']['isEmailVerified']=='N') {
	include('html/notVerified.htm');
	exit();
}

$checkTransfers = $GLOBALS['fn']->checkForTransfers($_SESSION['user']['id']);
if (!empty($checkTransfers)) {
	foreach ($checkTransfers as $k=>$v) {
		header('location:review.transfer.php?t='.$v['trf_id']);
		exit();
	}
}

header('location:load.owner.php?o='.$_SESSION['user']['id']);

?>