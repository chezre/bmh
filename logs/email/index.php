<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);



session_start();
$landingPage = 'index.php';
if (empty($_SESSION['user']['typeId'])) {
	header('location:../'.$landingPage);
	exit();
}

$typesAllowed = array(3,5);
if (!in_array($_SESSION['user']['typeId'], $typesAllowed)) {
	if (!empty($_SESSION['user']['landingPage'])) $landingPage = $_SESSION['user']['landingPage'];
	header('location:../'.$landingPage);
	exit();
}

$pdfs = glob("*.xml");
echo "<ul>";
foreach ($pdfs as $p) {
	echo '<li><a href="' . $p . '">' . $p . '</a></li>';
}
echo "</ul>";