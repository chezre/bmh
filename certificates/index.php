<?php

session_start();
if (!isset($_SESSION['user']['roleId'])||$_SESSION['user']['roleId']!=1) {
	if (isset($_SESSION['user']['landingPage'])) {
		header('location:../'.$_SESSION['user']['landingPage']);
		exit();
	} else {
		header('location:../index.php');
		exit();
	}
}

$pdfs = glob("*.pdf");
echo "<ul>";
foreach ($pdfs as $p) {
	echo '<li><a href="' . $p . '">' . $p . '</a></li>';
}
echo "</ul>";

?>