function validate() {
	var pwd = document.getElementById('usr_password');
	var cpwd = document.getElementById('confirm_password');
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
		
	document.frmPasswordReset.submit();
}