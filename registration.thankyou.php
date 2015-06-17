<?php

require('inc/application.php');

if (!empty($_GET['uti'])) {
	if ($_GET['uti']==1) include('html/registerThankyou.htm');
} else {
	include('html/adminRegisterThankyou.htm');
}

?>