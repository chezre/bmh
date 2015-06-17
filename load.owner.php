<?php

require('inc/application.php');
session_start();

if ($_SESSION['user']['isEmailVerified']=='N') {
	include('html/notVerified.htm');
	exit();
}

if (!isset($_GET['o'])||empty($_GET['o'])) {
	if (isset($_SESSION['user']['isAuthenticated'])) {
		header('location:'.$_SESSION['user']['landingPage']);
		exit();
	} else {
		header('location:index.php');
		exit();
	}
} 

# Is all pet owner details captured?
$pow = new extendedPetOwner();
$pow->LoadByUserId($_GET['o']);
if (empty($pow->pow_last_name)||(empty($pow->pow_cellphone_no)&&empty($pow->pow_telephone_no))) {
	header('location:edit.owner.php?o='.$pow->pow_usr_id);
	exit();
}

$myPets = $GLOBALS['fn']->getAllPetsForUser($_GET['o']);
$canAdd = (!empty($_SESSION['user'])&&($_SESSION['user']['roleId']!=3||$_SESSION['user']['id']==$_GET['o']));
$pets = '';
if (!empty($myPets)) {
 	foreach ($myPets as $p) {
 	 	if (empty($p['pet_species'])||empty($p['pet_breed'])||empty($p['pet_name'])) {
			header('location:edit.pet.php?p='.$p['pet_id']);
			exit();
		}
 	 	$viewHistory = '';
		if (isset($_SESSION['user']['roleId'])&&($_SESSION['user']['roleId']!=3||$_SESSION['user']['id']==$_GET['o'])) {
			$viewHistory = '<div class="vacHistory" onclick="window.location=\'edit.pet.php?p='.$p['pet_id'].'\'"><img src="img/edit-blue.png" valign="middle" height="24" width="24" /> edit pet</div><div class="vacHistory" onclick="window.location=\'pet.history.php?p='.$p['pet_id'].'\'"><img src="img/arrow-blue.png" valign="middle" height="24" width="24" /> more details</div>';
            
		}
	 	$petAge = floor( (strtotime(date('Y-m-d')) - strtotime($p['pet_birthdate'])) / 31556926);
	 	$notes = (empty($p['pet_general_notes'])) ? '&nbsp;':$p['pet_general_notes'];
	 	$features = (empty($p['pet_distinguishing_features'])) ? '&nbsp;':$p['pet_distinguishing_features'];
		$imgs = '';
		foreach (range(1,4) as $i) {
			if (!empty($p['pet_photo_'.$i])) $imgs .= '<img src="'.$p['pet_photo_'.$i].'" width="32" height="24" class="thumbNails" onclick="showImage(this,\'img-'.$p['pet_rfid'].'\')" />';
		}
		$mainPhoto = (empty($p['pet_photo_1'])) ? 'img/noimage.png':$p['pet_photo_1'];
		$pets .= '<div class="petMiniCard">
                        <div class="petDetails">
                			<table width="100%" cellpadding="5" cellspacing="0">
                                <tr>
                                    <td style="background-color: #33CCFF;color: #FFF;font-weight: bold">'.$p['pet_name'].'</td>
                                    <td>'.$p['pet_rfid'].'</td>
                                    <td class="lbl">Status</td>
                                    <td style="background-color: #33CCFF;color: #FFF;font-weight: bold">'.$p['pet_status'].'</td>
                                </tr>
                				<tr>
                                    <td class="lbl">Species</td>
                                    <td>'.$p['pet_species'].'</td>
                                    <td class="lbl">Sterilized</td>
                                    <td>'.$p['pet_sterilized'].'</td>
                                </tr>
                				<tr>
                                    <td class="lbl">Breed</td>
                                    <td>'.$p['pet_breed'].'</td>
                                    <td class="lbl">Sex</td>
                                    <td>'.$p['pet_sex'].'</td>
                                </tr>
                				<tr>
                                    <td class="lbl">Age</td>
                                    <td>'.$petAge.' yrs ('.$p['pet_birthdate'].')</td>
                                    <td class="lbl">Weight</td>
                                    <td>'.$p['pet_weight'].' kg</td>
                                </tr>
                				<tr>
                                    <td colspan="4" class="lbl">Notes</td>                                  
                                </tr>
                				<tr>
                                    <td colspan="4">'.$notes.'</td>
                                </tr>
                				<tr>
                                    <td colspan="4" class="lbl">Distinguishing Features</td>
                                </tr>
                				<tr>
                                    <td colspan="4">'.$features.'</td>
                                </tr>
                			</table>
                		</div>
                		<div class="primaryImage">
                			<img src="'.$mainPhoto.'" width="192" height="128" id="img-'.$p['pet_rfid'].'" />
                		</div>
                        <div class="imgSelect">
                			'.$imgs.'
                		</div>
                        '.$viewHistory.'
                	</div>';
	}
}

$u = new extendUser();
$u->Load($pow->pow_usr_id);

$navItem = '<li><a href="login.php">login</a></li>';	
$isOwnerOrAdmin = (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']=='Y'&&($_SESSION['user']['id']==$_GET['o']||$_SESSION['user']['roleId']!=3));
if (isset($_SESSION['user']['isAuthenticated'])&&$_SESSION['user']['isAuthenticated']=='Y') {
	$navItem = '<li><a href="logout.php">logout</a></li>';	
}


include('html/load.owner.htm');