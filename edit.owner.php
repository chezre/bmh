<?php

require('inc/application.php');
require('inc/security.php');

if ($_SESSION['user']['isEmailVerified']=='N') {
	include('html/notVerified.htm');
	exit();
}

if (!isset($_GET['o'])||empty($_GET['o'])||($_SESSION['user']['id']!=$_GET['o']&&$_SESSION['user']['roleId']==3)) {
	header('location: index.php');
	exit();
}

$isSuperUser = (isset($_SESSION['user']['roleId'])&&$_SESSION['user']['roleId']!=1);
$canEdit = (isset($_SESSION['user']['roleId'])&&($_SESSION['user']['roleId']==1||$_GET['o']==$_SESSION['user']['id']));

$u = new extendUser();
$u->Load($_GET['o']);

$o = new extendedPetOwner();
$o->LoadByUserId($_GET['o']);

include('html/edit.owner.htm');

?>