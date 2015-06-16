<?php 

require('inc/application.php');
require('inc/security.php');

if ($_SESSION['user']['roleId']!=1) {
	header('location:'.$_SESSION['user']['landingPage']);
	exit();
}

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!empty($_FILES)) {
    $newLocation = 'uploads/'.$_FILES['filename']['name'];
    if (!preg_match('/.csv/',$newLocation)) {
        header('location: '.$_SESSION['user']['landingPage'].'?r=rifailed');
        exit();
    }
    move_uploaded_file($_FILES['filename']['tmp_name'],$newLocation);
    $handle = fopen($newLocation,'r');
    $records = array();
    while ( ($data = fgetcsv($handle) ) !== FALSE ) {
        $records[] = $data;
    }
    $result = 'risuccess';
    $cnt = 0;

    if (trim($records[0][0])!='rfid'&&trim($records[0][0])!='invoiceno') {
    	$result = 'rifailed';
    } else {
    	if (!empty($records)) {
	    	foreach ($records[0] as $k=>$v) $columnHeading[trim($v)] = $k;
	    	$cnt = 0;
	        foreach ($records as $r) {
	            if (trim($r[0])=='rfid'||trim($r[1])=='rfid'||trim($r[0])=='invoiceno'||trim($r[1])=='invoiceno') continue;
	            $p = new extendedPet();
				if (empty($r[$columnHeading['rfid']])) continue;
	            if ($p->LoadByRFID($r[$columnHeading['rfid']])) continue;
	   	    	$p->pet_rfid = trim($r[$columnHeading['rfid']]);
		    	$p->pet_invoice_no = trim($r[$columnHeading['invoiceno']]);
				if ($p->Import()) $cnt++;
	        }
	    } else {
	    	$result = 'rifailed';
	    }
	}
    header('location: '.$_SESSION['user']['landingPage'].'?r='.$result.'&c='.$cnt);
    exit();
}
header('location: '.$_SESSION['user']['landingPage']);


?>