<?php

require('inc/application.php');
require('inc/security.php');
if (!isset($_SESSION['user']['roleId'])||$_SESSION['user']['roleId']!=1) {
	if (isset($_SESSION['user']['landingPage'])) {
		header('location:'.$_SESSION['user']['landingPage']);
		exit();
	} else {
		header('location:index.php');
		exit();
	}
}

$sql = "select 
	month(`usr_created_datetime`) `Month`,
	count(distinct `usr_id`) `Registered`,
	count(distinct `pet_rfid`) `rfid`,
	count(`usr_verified_datetime`) `Email Verified` 
from `user` 
left join `pet` ON `pet_usr_id` = `usr_id`
where `usr_created_datetime` between '2015-04-01' and '2015-05-13'
		group by 1;";

$data = $GLOBALS['db']->select($sql);
$return['data'] = array();
if (empty($data)) {
	$return['message'] = "No data found";
} else {
	$return['data'] = $data;
	$return['message'] = count($data) . " records found";
}
echo "<pre />";
echo json_encode($return);