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

$v = new extendedVet();
$v->Load($_GET['vet_id']);

$u = new extendUser();
$u->Load($v->vet_usr_id);

?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btnSaveVet").click(function(){
			$("#saveResult").empty().append("saving...").show();
			$.post("admin.save.vet.php",$("#frmVet").serialize()).done(function(data)
			{
				var json = $.parseJSON(data);
				$("#saveResult").empty().append(json.message).show();
			});
		});
	});
</script>
<div class="formHeading">Vet Details</div>
<form action="admin.save.vet.php" method="POST" id="frmVet" name="frmVet">
	<input type="hidden" name="vet_id" id="vet_id" value="<?php echo $v->vet_id; ?>" />
<table width="100%" cellspacing="0" align="center">
	<tr>
	 	<td>
		 	<label for="usr_email">Email</label>
		</td>
		<td>
			<?php echo $u->usr_email; ?>
			<input type="hidden" name="usr_email" value="<?php echo $u->usr_email; ?>" />
			<input type="hidden" name="usr_id" value="<?php echo $u->usr_id; ?>" />
            <input type="hidden" name="vet_usr_id" value="<?php echo $u->usr_id; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="vet_name" title="Your full name">Full Name</label> &#42;
		</td>
		<td align="right">
			<input class="inp" type="text" name="vet_name" id="vet_name" title="Your full name" value="<?php echo $v->vet_name; ?>" />
		</td>
	</tr>
	<!--tr>
	 	<td>
		 	<label for="vet_statutory_id" title="Your South African ID number">ID Number</label> &#42;
		</td>
		<td align="right">
			<input class="inp" type="text" name="vet_statutory_id" id="vet_statutory_id" title="Your South African ID number" value="<?php echo $v->vet_statutory_id; ?>"  />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="vet_cellphone_no" title="Your cellphone number">Cellphone</label> &#42;
		</td>
		<td align="right">
			<input class="inp" type="text" name="vet_cellphone_no" id="vet_cellphone_no" title="Your cellphone number" value="<?php echo $v->vet_cellphone_no; ?>" />
		</td>
	</tr-->
	<tr>
	 	<td colspan="2" style="font-size: 18pt"><hr style="color: #33CCFF;" />Practice details</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="vet_practice_no" title="Your South African Vet&apos;s association practice number">SAVA Number</label> &#42;
		</td>
		<td align="right">
			<input class="inp" type="text" name="vet_practice_no" id="vet_practice_no" title="Your South African Vet&apos;s association practice number" value="<?php echo $v->vet_practice_no; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="vet_practice_name">Practice name</label>
		</td>
		<td align="right">
			<input class="inp" type="text" name="vet_practice_name" id="vet_practice_name" value="<?php echo $v->vet_practice_name; ?>" />
		</td>
	</tr>
	<tr>
	 	<td rowspan="3" valign="top">
		 	<label for="vet_practice_address_1">Address</label>
		</td>
		<td align="right">
			<input class="inp" type="text" name="vet_practice_address_1" id="vet_practice_address_1" value="<?php echo $v->vet_practice_address_1; ?>" />
		</td>
	</tr>
	<tr>
		<td align="right">
			<input class="inp" type="text" name="vet_practice_address_2" id="vet_practice_address_2" value="<?php echo $v->vet_practice_address_2; ?>" />
		</td>
	</tr>
	<tr>
		<td align="right">
			<input class="inp" type="text" name="vet_practice_address_3" id="vet_practice_address_3" value="<?php echo $v->vet_practice_address_3; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="vet_practice_postal_code">Postal Code</label>
		</td>
		<td align="right">
			<input class="inp" type="text" name="vet_practice_postal_code" id="vet_practice_postal_code" value="<?php echo $v->vet_practice_postal_code; ?>" />
		</td>
	</tr>
	<tr>
	 	<td>
		 	<label for="vet_practice_telephone_no" title="Your telephone number">Telephone</label> &#42;
		</td>
		<td align="right">
			<input class="inp" type="text" name="vet_practice_telephone_no" id="vet_practice_telephone_no" title="Your telephone number" value="<?php echo $v->vet_practice_telephone_no; ?>" />
		</td> 
	</tr>
	<tr>
	 	<td>
		 	<label for="vet_practice_fax_no">Fax No</label>
		</td>
		<td align="right">
			<input class="inp" type="text" name="vet_practice_fax_no" id="vet_practice_fax_no" value="<?php echo $v->vet_practice_fax_no; ?>" />
		</td>
	</tr>
</table>
<div class="btn" id="btnSaveVet">Save</div>
</form>