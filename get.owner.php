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

$o = new extendedPetOwner();
$o->LoadByUserId($_GET['pow_usr_id']);


$u = new extendUser();
$u->Load($_GET['pow_usr_id']);

?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btnSaveOwner").click(function(){
			$.post("admin.save.owner.php",$("#frmOwner").serialize()).done(function(data)
			{
				var json = $.parseJSON(data);
				$("#btnSearch").click();
				
			});
		});
	});
</script>
<div class="formHeading">Owner Details</div>
<form action="admin.save.owner.php" method="POST" id="frmOwner" name="frmOwner">
	<input type="hidden" name="pow_id" id="pow_id" value="<?php echo $o->pow_id; ?>" />
<table width="100%" cellspacing="0" align="center">
	<tr>
	 	<td>
		 	<label for="usr_email">Email</label>
		</td>
		<td>
			<input type="text" name="usr_email" value="<?php echo $u->usr_email; ?>" />
			<input type="hidden" name="usr_id" value="<?php echo $u->usr_id; ?>" />
            <input type="hidden" name="pow_usr_id" value="<?php echo $u->usr_id; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pow_first_name">First Name</label>
		</td>
		<td>
			<input type="text" name="pow_first_name" id="pow_first_name" value="<?php echo $o->pow_first_name; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pow_last_name">Last Name</label>
		</td>
		<td>
			<input type="text" name="pow_last_name" id="pow_last_name" value="<?php echo $o->pow_last_name; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pow_address_1">Address line 1</label>
		</td>
		<td>
			<input type="text" name="pow_address_1" id="pow_address_1" value="<?php echo $o->pow_address_1; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pow_address_2">Address line 2</label>
		</td>
		<td>
			<input type="text" name="pow_address_2" id="pow_address_2" value="<?php echo $o->pow_address_2; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pow_address_3">Address line 3</label>
		</td>
		<td>
			<input type="text" name="pow_address_3" id="pow_address_3" value="<?php echo $o->pow_address_3; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pow_postal_code">Postal Code</label>
		</td>
		<td>
			<input type="text" name="pow_postal_code" id="pow_postal_code" value="<?php echo $o->pow_postal_code; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pow_country">Country</label>
		</td>
		<td>
			<input type="text" name="pow_country" id="pow_country" value="<?php echo $o->pow_country; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pow_cellphone_no">Cellphone Number</label>
		</td>
		<td>
			<input type="text" name="pow_cellphone_no" id="pow_cellphone_no" value="<?php echo $o->pow_cellphone_no; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="pow_telephone_no">Telephone Number</label>
		</td>
		<td>
			<input type="text" name="pow_telephone_no" id="pow_telephone_no" value="<?php echo $o->pow_telephone_no; ?>" />
		</td>
	</tr>
</table>
<div class="btn" id="btnSaveOwner">Save</div>
</form>