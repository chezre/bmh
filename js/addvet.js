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
	
	var stateId = document.getElementById('vet_statutory_id');
	if (stateId.value.trim().length==0) {
		alert('Your ID number is required.');
		stateId.focus();
		return;
	}
	
	var pracNo = document.getElementById('vet_practice_no');
	if (fname.value.trim().length==0) {
		alert('Your practice number is required.');
		pracNo.focus();
		return;
	}
	
	var cellphone = document.getElementById('vet_cellphone_no');
	var telephone = document.getElementById('vet_practice_telephone_no');
	if (cellphone.value.trim().length==0&&telephone.value.trim().length==0) {
		alert('Your cellphone number/landline number is required.');
		return;
	}
		
	document.frmAddvet.submit();
}

$(function() {
  $( document ).tooltip({tooltipClass: "toolTipStyling"});
});