<?php 

require('inc/application.php');
session_start();
$currentPage = preg_replace("/\//",'',$_SERVER['SCRIPT_NAME']);
$homePage = '<a href="index.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; search</a>';
$navItem = '&nbsp;<a href="login.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; login</a>';	
if (!empty($_SESSION['user']['isAuthenticated'])) {
	$navItem = '<a href="logout.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; logout</a>';	
	$homePage = '&nbsp;<a href="'.$_SESSION['user']['landingPage'].'" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; home</a>';
}
$showFailMessage = (isset($_GET['f'])&&$_GET['f']=='email') ? '':' style="display:none;"';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Multiple Vet Registration</title>
        <link rel="icon" type="image/png" href="img/favicon.png" />
		<link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="css/global.css" />
        <link rel="stylesheet" type="text/css" href="css/addvet.css" />

        <script type="text/javascript" language="javascript" src="js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script type="text/javascript" lang="javascript">
			var captchaOk = false;
			$(document).ready(function(){
				$("#imgSubmit").click(function() {
					validate();
				});
				bindBtns();
				$(".saveBtn").click(function(){
					$(".newVet").each(function(){
						var inputCnt = 0;
						var strPost = 'isAdmin=Y';
						$(this).find("input").each(function(){
							if ($(this).val().trim().length>0) {
								inputCnt++;
								strPost += '&' + $(this).attr('name') + '=' + $(this).val();
							}
						});
						if (inputCnt>0) {
							var $me = $(this);
							$.post('script.addvet.php',strPost).done(function(data){
								var json = $.parseJSON(data);
								console.log(json);
								$me.find('.msg').empty().append(json.message);
							});
						}
					});
				});
				$("#btnClear").click(function(){
					$("input").val('');
					$(".msg").empty();
				});
			});
			function bindBtns() {
				
				$(".addBtn").click(function(){
					var h = $("#newVetRow").html();
					$("#tblVets").append('<tbody class="newVet">'+h+'</tbody>');
					bindBtns();
					$(this).hide();
				});
			}
			function validate() {
				
				var email = document.getElementById('usr_email');
				if (email.value.trim().length==0) {
					alert('The email address is required to login.');
					email.focus();
					return;
				}
				
				if (email.value.trim().indexOf('@')==-1||email.value.trim().indexOf('.')==-1) {
					alert('Email address is invalid');
					email.focus();
					return;
				}
				
				var cfm_email = document.getElementById('cfm_email');
				if (email.value.trim()!=cfm_email.value.trim()) {
					alert('The email address was not correctly confirmed');
					cfm_email.focus();
					return false;
				}
				
				var pwd = document.getElementById('usr_password');
				var cpwd = document.getElementById('usr_password_confirm');
				if (pwd != null) {
					if (pwd.value.trim().length==0) {
						alert('The password is required');
						pwd.focus();
						return;
					}
					if (pwd.value.trim().length<6) {
						alert('Your password must contain at least 6 characters');
						pwd.focus();
						return;
					}
					if (cpwd.value.trim().length==0) {
						alert('Please confirm your password.');
						cpwd.focus();
						return;
					}
					if (pwd.value.trim() != cpwd.value.trim()) {
						alert('Your passwords don\'t match.');
						return;
					}
				}
				
				var fname = document.getElementById('vet_name');
				if (fname.value.trim().length==0) {
					alert('Your full name is required.');
					fname.focus();
					return;
				}
					
				var pracNo = document.getElementById('vet_practice_no');
				if (fname.value.trim().length==0) {
					alert('Your practice number is required.');
					pracNo.focus();
					return;
				}
				var telephone = document.getElementById('vet_practice_telephone_no');
				if (telephone.value.trim().length==0) {
					alert('Your telephone number is required.');
					return;
				}
				
				//document.frmAddvet.submit();
			}
	</script>
        
	</head>
	<body>
		<div id="mainDiv">
            <div style="padding:20px;width: auto !important;text-align: center;">
                <img src="img/bmh_logo.png" width="265" height="86" />
				<hr />
            </div>
			<div id="headingDiv" class="hdrDiv">Add VET</div>
  
            <!-- start here -->
			<div class="fail" <?php echo $showFailMessage; ?>>The email address you entered alread exists in our database. <br />Try resetting your password <a href="reset.login.php">here</a></div>
			
			
            <div id="vetFrm">
    		 	<form action="script.addvet.php" method="POST" onsubmit="return validate();" id="frmAddvet" name="frmAddvet" >
                <table width="100%" cellspacing="0" cellpadding="5" id="tblVets">
					<tbody id="newVetRow" style="display:none">
						<tr>
	    					<td><input type="email" name="usr_email" placeholder="Email Address" /></td>
	    					<td><input type="text" name="vet_name" placeholder="Full Name" /></td>
							<td><input type="text" name="vet_practice_no" placeholder="SAVA Number" /></td>
							<td><input type="text" name="vet_practice_name" placeholder="Practice Name" /></td>
							<td><input type="text" name="vet_practice_address_1" placeholder="Practice Address" /></td>
							<td><input type="text" name="vet_practice_address_2" /></td>
							<td><input type="text" name="vet_practice_address_3" /></td>
							<td><input type="text" name="vet_practice_postal_code" placeholder="Postal Code" /></td>
						</tr>
						<tr>
							<td><input type="text" name="vet_practice_telephone_no" placeholder="Telephone No" /></td>
							<td><input type="text" name="vet_practice_fax_no" placeholder="Fax No" /></td>
							<td><div class="addBtn">Add</div></td>
							<td colspan="5" class="msg">&nbsp;</td>
						</tr>
					</tbody>
					<tbody id="tbodyVets" class="newVet">
						<tr>
	    					<td><input type="email" name="usr_email" placeholder="Email Address" /></td>
	    					<td><input type="text" name="vet_name" placeholder="Full Name" /></td>
							<td><input type="text" name="vet_practice_no" placeholder="SAVA Number" /></td>
							<td><input type="text" name="vet_practice_name" placeholder="Practice Name" /></td>
							<td><input type="text" name="vet_practice_address_1" placeholder="Practice Address" /></td>
							<td><input type="text" name="vet_practice_address_2" /></td>
							<td><input type="text" name="vet_practice_address_3" /></td>
							<td><input type="text" name="vet_practice_postal_code" placeholder="Postal Code" /></td>
						</tr>
						<tr>
							<td><input type="text" name="vet_practice_telephone_no" placeholder="Telephone No" /></td>
							<td><input type="text" name="vet_practice_fax_no" placeholder="Fax No" /></td>
							<td><div class="addBtn">Add</div></td>
							<td colspan="5" class="msg">&nbsp;</td>
						</tr>
					</tbody>
    			</table>
				<div class="saveBtn" id="btnSave">Save</div>
				<div id="btnClear">Clear</div>
    			</form>
            </div>
            <div style="margin-top: 15px;margin-bottom: 15px;clear: both;">
				<?php echo $navItem.' '.$homePage; ?>
			</div>
		</div>
        <div id="footerDiv">
            All Rights Reserved &reg;. BringMeHome Microchip Database &#124; <a href="contactus.php">Contact Us</a> &#124; <a href="legal.php">Legal</a>
        </div>
	</body>
	</html>