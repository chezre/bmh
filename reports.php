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

$xml = simplexml_load_file('inc/report.stats.config.xml');
$metrics = '';
foreach ($xml->children() as $x) {
	$total = $GLOBALS['fn']->{(string)$x['totalFn']}();
	$metrics .= '<div class="metricDiv" val="'.$x['id'].'">
					<div class="val">'.$total.'</div>
					<div class="desc" title="'.$x['title'].'">'.$x['desc'].'</div>
					</div>';
}
$totalCompleted = $GLOBALS['fn']->getTotalCompletedRegistrations();
include('html/reports.htm');