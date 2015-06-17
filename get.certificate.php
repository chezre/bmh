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

$o = new extendedPetOwner();
$o->LoadByUserId($_GET['pow_usr_id']);

if (!empty($p->pet_certificate_emailed)) {
	$certificateDate = $p->pet_certificate_emailed;
	$sendAgain = ' again';
} else {
	$certificateDate = 'Certificate Not Sent yet';
	$sendAgain = '';
}

$u = new extendUser();
$u->Load($p->pet_usr_id);
$listItems = '<li><input type="hidden" name="toUsrId" value="' . $p->pet_usr_id . '" /><label for="toUsrId">To: '.$o->pow_first_name. ' ' .$o->pow_last_name. ' &lt;'.$u->usr_email.'&gt;</li>';

if (!empty($GLOBALS['cfg']->KUSA->toAddresses)) {
	foreach ($GLOBALS['cfg']->KUSA->toAddresses->children() as $e) {
		$listItems .= '<li>KUSA: '.$e['name']. ' &lt;'.$e['email'].'&gt;</li>';
	}
}

?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btnSendCertificate").click(function(){
			$("#sendFormDiv").hide();
			$("#sendingDiv").show();
			$.post("admin.save.certificate.php",$("#frmCertificate").serialize()).done(function(data)
			{
				var json = $.parseJSON(data);
				$("#btnSearch").click();
				
			});
		});
	});
</script>
<div class="formHeading">Send Certificate</div>
<div id="sendFormDiv">
<form action="admin.save.certificate.php" method="POST" id="frmCertificate" name="frmCertificate">
	<input type="hidden" name="pet_id" id="pet_id" value="<?php echo $_GET['pet_id']; ?>" />
	<div id="certificateDateDiv">
		<?php echo $certificateDate; ?>
		<ul>
			<?php echo $listItems; ?>
		</ul>
	</div>
	<div class="btn" id="btnSendCertificate">Send<?php echo $sendAgain; ?></div>
</form>
</div>
<div id="sendingDiv" style="display:none">Sending...</div>