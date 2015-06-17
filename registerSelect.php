<?php 
	$registerChecked = '';
	$addvetChecked = '';
	$addwelfareChecked = '';
	switch ($currentPage) {
		case "register.php":
			$registerChecked = 'checked';
			break;
		case "addvet.php":
			$addvetChecked = 'checked';
			break;
		case "addwelfare.php":
			$addwelfareChecked = 'checked';
			break;
		default:
			$addvetChecked = 'checked';
			break;
	}
?>
		<link rel="stylesheet" type="text/css" href="css/registerselect.css" />
		<script type="text/javascript" language="javascript">
			function goToRegistration(el) {
				window.location = el.value;
			}
		</script>
		<div id="registerDiv">
			<div style="margin-bottom: 15px;font-size:18pt;">Register as</div>
			<input type="radio" style="width:15px;" name="registrationType" value="register.php" id="petOwnerButton" <?php echo $registerChecked; ?> onchange="goToRegistration(this)" /><label for="petOwnerButton"> Pet Owner</label>
			<input type="radio" style="width:15px;margin-left:10px;" name="registrationType" value="addvet.php" id="vetButton" <?php echo $addvetChecked; ?> onchange="goToRegistration(this)" /><label for="vetButton"> Vet</label>
			<input type="radio" style="width:15px;margin-left:10px;" name="registrationType" value="addwelfare.php" id="welfareButton" <?php echo $addwelfareChecked; ?> onchange="goToRegistration(this)" /><label for="welfareButton"> Welfare Organisation</label>
		</div>