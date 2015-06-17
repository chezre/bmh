<?php 

require('inc/application.php');
require('inc/security.php');

session_destroy();

header('location:login.php');

?>