<?php 

require('inc/application.php');
require('inc/security.php');

$v = new extendedVet();
$v->Load($_POST['vet_id']);

foreach ($_POST as $k=>$val) $v->$k = $val;
$v->Save();
$result['request'] = $v;
$result['message'] = 'VET details saved';

echo json_encode($result);