<?php

require('inc/application.php');
require('inc/security.php');

$email = $_SESSION['user']['email'];

include('html/reset.password.htm');

?>