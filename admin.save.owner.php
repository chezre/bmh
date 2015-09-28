<?php 

require('inc/application.php');
require('inc/security.php');

$p = new extendedPetowner();
if (empty($_POST['pow_id'])) {
    $p->LoadByUserId($_POST['pow_usr_id']);
} else {
    $p->Load($_POST['pow_id']);
       
}
foreach ($_POST as $k=>$v) $p->$k = $v;
$p->Save();
$result['request'] = $p;
$result['message'] = 'Pet Owner details saved';

echo json_encode($result);