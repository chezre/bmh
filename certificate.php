<?php

require('inc/application.php');
session_start();
if (!isset($_GET['p'])||empty($_GET['p'])) exit();

error_reporting(E_ALL);
ini_set('display_errors', '1');

$pet = new extendedPet();
$pet->Load($_GET['p']);

if (empty($pet->pet_usr_id)) exit();
$pow = new extendedPetOwner();
$pow->LoadByUserId($pet->pet_usr_id);

$ownerAddress = $pow->pow_address_1;
if (!empty($ownerAddress)) $ownerAddress .= ', ';
$ownerAddress .= $pow->pow_address_2;
if (!empty($pow->pow_address_2)&&!empty($pow->pow_address_3)) $ownerAddress .= ', ';
$ownerAddress .= $pow->pow_address_3;

if (empty($pow->pow_usr_id)) exit();
$u = new extendUser();
$u->Load($pow->pow_usr_id);

if (empty($pet->pet_assigned_by_usr_id)) exit();
$injectedBy = $GLOBALS['fn']->getInjectorInfo($pet->pet_assigned_by_usr_id);

$margins = array(0,0,0,0);
ob_start();
include('html/certificate.htm');
$content = ob_get_clean();
$filename = $pet->pet_rfid.'-certification.pdf';
try
{
    $html2pdf = new HTML2PDF('P', 'A4', 'en',false,'ISO-8859-15',$margins);
    $html2pdf->setDefaultFont('frutiger');
    $html2pdf->writeHTML($content);
    $html2pdf->Output($filename);
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}

?>