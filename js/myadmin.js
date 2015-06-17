$(document).ready(function() {
	$("#btnResetPassword").click(function() {
		if ($("#email").val().length==0) {
			alert("Please enter email address");
			$("#email").focus();
			return;
		}
		if ($("#password").val().length==0) {
			alert("Please enter the new password");
			$("#password").focus();
			return;
		}
		if ($("#confirm").val().length==0) {
			alert("Please confirm the new password");
			$("#confirm").focus();
			return;
		}
		if ($("#password").val()!=$("#confirm").val()) {
			alert("The password and password confirmation dont match");
			$("#password").focus();
			return;
		}
		$form = $("#frmResetPassword");
		var strUrl = $form.attr("action");
		$.post(strUrl,$form.serialize()).done(function(data) {
			$("#pwdMsg").empty().append(data);
			$("#pwdMsg").show();
			$form.trigger('reset');
		});
		
	});
	$("#btnResendEmail").click(function() {
		if ($("#resendEmailAddress").val().length==0) {
			alert("Please enter email address");
			$("#resendEmailAddress").focus();
			return;
		}
		$form = $("#frmResendEmail");
		var strUrl = $form.attr("action");
		$.post(strUrl,$form.serialize()).done(function(data) {
			$("#emlMsg").empty().append(data);
			$("#emlMsg").show();
			$form.trigger('reset');
		});
	});
});

function loadUser(usrId,usrType) {
	document.getElementById('usr_id').value = usrId;
	document.frmSearch.action = 'load.' + usrType + '.php';
	document.frmSearch.submit();
}