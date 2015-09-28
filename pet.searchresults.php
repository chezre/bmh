<?php 

require('inc/application.php');
session_start();
$adminColors = (!empty($_SESSION['user']['isAuthenticated'])&&preg_match('/[1-2]/',$_SESSION['user']['roleId']));
$color = ($adminColors) ? 'blue':'blue';
$rwClass = ($adminColors) ? 'adminRow':'nonAdminRow';
$hdRowClass = ($adminColors) ? 'adminHeadingRow':'headingRow';
if (isset($_SESSION['user']['id']) && $_SESSION['user']['id']>0) {
	$homePage = $_SESSION['user']['landingPage'];
	$navItem = '<div style="float:right;cursor: pointer;margin-left:15px">
		<a href="logout.php"><img src="img/login-'.$color.'.png" height="24" width="24" align="middle" /> logout</a>
                </div>';
} else {
	$homePage = 'index.php';
	$navItem = '<div style="float:right;cursor: pointer;margin-left:15px">
		<a href="login.php"><img src="img/login-'.$color.'.png" height="24" width="24" align="middle" /> login</a>
                </div>';
}
$searchResultRows = '<tr><td colspan="5">No pets found</td></tr>';


$ownerName = (isset($_POST['owner_name'])) ? $_POST['owner_name']:'';
	$ownerEmail = (isset($_POST['owner_email'])) ? $_POST['owner_email']:'';
	$searchResults = $GLOBALS['fn']->petSearch($_POST['pet_rfid'],$ownerName,$ownerEmail);
    $isRegistrationComplete = true;
	
	if (!empty($searchResults)) {
		$searchResultRows = '';
		foreach ($searchResults as $k=>$v) {
			$owner = new extendedPetOwner();
			$ownerOk = (empty($v['pet_usr_id'])) ? false:$owner->LoadByUserId($v['pet_usr_id']);
			
			$user = new extendUser();
			$userOk = ($ownerOk) ? $user->Load($owner->pow_usr_id):false;
			if (!empty($v['pet_register_date'])&&$userOk&&$ownerOk)
			{
				$searchResultRows .= '<tr onclick="window.location=\'load.pet.php?p='.$v['pet_id'].'\'" class="'.$rwClass.'">';
		        $searchResultRows .= (!empty($v['pet_photo_1'])) ? '<td><img src="'.$v['pet_photo_1'].'" width="48" height="32" /></td>':'<td>&nbsp;</td>';
				$searchResultRows .= '<td>'.$v['pet_rfid'].'</td>';
				$searchResultRows .= '<td>'.$v['pet_name'].'</td>';
				$searchResultRows .= '<td>'.$v['Owner Name'].'</td>';
				$searchResultRows .= '</tr>';
			} else {
			 $isRegistrationComplete = false;
				$searchResultRows .= '<tr class="'.$rwClass.'"><td>&nbsp;</td><td colspan="3">' . $v['pet_rfid'] . ' not registered yet</td></tr>';
			}
		}
	}
	

include('html/pet.searchresults.htm');

?>