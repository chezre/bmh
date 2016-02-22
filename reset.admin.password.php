<?php

require('inc/application.php');
require('inc/security.php');

$u = new extendUser();
$u->LoadByEmail("admin@bringmehome.co.za");
$u->setPassword("SamAdmin15#");
$u->Save();

echo "done";