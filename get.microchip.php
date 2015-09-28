<?php

require('inc/application.php');
require('inc/security.php');
if (!isset($_SESSION['user']['roleId'])||$_SESSION['user']['roleId']!=1) {
	if (isset($_SESSION['user']['landingPage'])) {
		header('location:'.$_SESSION['user']['landingPage']);
		exit();
	} else {
		header('location:index.php');
		exit();
	}
}


$p = new extendedPet();
$p->Load($_GET['pet_id']);

$sexes = array('M','F');
$petSexOpts = '';
foreach ($sexes as $s) {
 	$selected = ($p->pet_sex==$s) ? ' SELECTED':'';
	$petSexOpts .= '<option value="'.$s.'"'.$selected.'>'.$s.'</option>';	
}

$steris = array('Y','N');
$steriOpts = '';
foreach ($steris as $s) {
	$selected = ($p->pet_sterilized==$s) ? ' SELECTED':'';
	$steriOpts .= '<option value="'.$s.'"'.$selected.'>'.$s.'</option>';
}

$species = $GLOBALS['fn']->getAllSpecies();
$speciesOpts = '';
foreach ($species as $s) {
	$selected = ($p->pet_species==$s['spe_description']) ? ' SELECTED':'';
	$speciesOpts .= '<option value="'.$s['spe_description'].'"'.$selected.'>'.$s['spe_description'].'</option>';
}

$statusOpts = '';
$statuses = $GLOBALS['fn']->getPetStatuses();
foreach ($statuses as $k=>$v) {
 	if ($v['sta_description']=='in transfer') continue;
 	$selected = ($p->pet_status==$v['sta_description']) ? ' SELECTED':'';
	$statusOpts .= '<option value="'.$v['sta_description'].'"'.$selected.'>'.$v['sta_description'].'</option>';
}

$vetIdOpts = '<option value="">-- select --</option>';
$vetIds = $GLOBALS['fn']->getInjectors();
foreach ($vetIds as $k=>$v) {
	$selected = ($p->pet_assigned_by_usr_id==$v['usr_id']) ? ' SELECTED':'';
	$vetIdOpts .= '<option value="'.$v['usr_id'].'" title="'.$v['user_type'].'"'.$selected.'>'.$v['practice_name'].' (' . $v['name'];
	$vetIdOpts .= (empty($v['practice_no'])) ? '' : ' ' . $v['practice_no'];
	$vetIdOpts .= ')</option>';
}

?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btnSaveChip").click(function(){
			$.post("admin.save.chip.php",$("#frmChip").serialize()).done(function(data){
				var json = $.parseJSON(data);
				$("#btnSearch").click();
			});
		});
	});
</script>
<div class="formHeading">Microchip Details</div>
<form action="admin.save.chip.php" method="POST" id="frmChip" name="frmChip">
<input type="hidden" name="pet_usr_id" id="pet_usr_id" value="<?php echo $_GET['pow_usr_id']; ?>" />
<input type="hidden" name="pet_rfid" id="pet_rfid" value="<?php echo $p->pet_rfid; ?>" />
<input type="hidden" name="pet_id" value="<?php echo $p->pet_id; ?>" />
<table width="100%" cellspacing="0" align="center">
	<tbody style="background-color: #e7e7e7">
		
	<?php  /* if (empty($p->pet_assigned_by_usr_id)||$p->pet_assigned_by_usr_id==$p->pet_usr_id) { */ ?>
	<tr>
	 	<td>
		 	<label for="pet_assigned_by_usr_id">Vet</label> &#42;
		</td>
		<td>
			<select class="inp" name="pet_assigned_by_usr_id" id="pet_assigned_by_usr_id">
				<?php echo $vetIdOpts; ?>
			</select>
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_implanted_date">Date Microchip Implanted</label>
		</td>
		<td>
			<input class="inp" type="date" name="pet_implanted_date" id="pet_implanted_date" value="<?php echo $p->pet_implanted_date; ?>" />
		</td>
	</tr>
		<?php /* } */ ?>
	</tbody>
	<tbody style="background-color: #FFF">
		<tr>
	 	<td>
		 	<label for="pet_name">Pet&apos;s name</label> &#42;
		</td>
		<td>
			<input class="inp" type="text" name="pet_name" id="pet_name" value="<?php echo $p->pet_name; ?>"  />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_sex">Sex</label> 
		</td>
		<td>
			<select class="inp" name="pet_sex" id="pet_sex">
				<?php echo $petSexOpts; ?>
			</select>
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_sterilized">Sterilized</label>
		</td>
		<td>
			<select class="inp" name="pet_sterilized" id="pet_sterilized">
				<?php echo $steriOpts; ?>
			</select>
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_breed">Breed</label> &#42;
		</td>
		<td>
			<input class="inp" type="text" name="pet_breed" id="pet_breed" value="<?php echo $p->pet_breed; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_species">Species</label> &#42;
		</td>
		<td>
			<select class="inp" name="pet_species" id="pet_species" onchange="isHorse(this);">
				<?php echo $speciesOpts; ?>
			</select>
		</td>
	</tr>
	<tr style="display:none;" id="heightRow">
		<td>
			<label for="pet_height">Height (hands)</label>
		</td>
		<td><input type="text" id="pet_height" name="pet_height" value="<?php echo $p->pet_height; ?>" /></td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_birthdate">Birth date</label>
		</td>
		<td>
			<input class="inp" type="text" name="pet_birthdate" id="pet_birthdate" value="<?php echo $p->pet_birthdate; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_colour">Colour</label> &#42;
		</td>
		<td>
			<input class="inp" type="text" name="pet_colour" id="pet_colour" value="<?php echo $p->pet_colour; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_distinguishing_features">Distinguishing features</label>
		</td>
		<td>
			<textarea cols="28" name="pet_distinguishing_features" id="pet_distinguishing_features"><?php echo $p->pet_distinguishing_features; ?></textarea>
		</td>
	</tr>
	<!--?php } ?-->
	<tr>
	 	<td>
		 	<label for="pet_breeder_society">Breeder Society</label>
		</td>
		<td>
			<input class="inp" type="text" name="pet_breeder_society" id="pet_breeder_society" value="<?php echo $p->pet_breeder_society; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_weight">Weight (kg)</label>
		</td>
		<td>
			<input class="inp" type="text" name="pet_weight" id="pet_weight" value="<?php echo $p->pet_weight; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_general_notes">Notes</label>
		</td>
		<td>
			<textarea cols="28" name="pet_general_notes" id="pet_general_notes"><?php echo $p->pet_general_notes; ?></textarea>
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pet_status">Status</label>
		</td>
		<td>
			<select name="pet_status" id="pet_status" class="inp" onchange="confirmStatusUpdate()"><?php echo $statusOpts; ?></select>
			<input type="hidden" id="old_status" value="<?php echo $p->pet_status; ?>" />
		</td>
	</tr>
</tbody>
</table>
<div class="btn" id="btnSaveChip">Save</div>
</form>