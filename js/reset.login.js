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
	document.frmResetpass.submit();
}