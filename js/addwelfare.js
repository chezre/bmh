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
	
	var wname = document.getElementById('wel_name');
	if (wname.value.trim().length==0) {
		alert('The welfare organisation\'s name is required.');
		wname.focus();
		return;
	}
	
	var waddr1 = document.getElementById('wel_address_1');
	var waddr2 = document.getElementById('wel_address_2');
	if (waddr1.value.trim().length==0&&waddr2.value.trim().length==0) {
		alert('The welfare organisation\'s address is required.');
		waddr1.focus();
		return;
	}
	
	var wpcode = document.getElementById('wel_postal_code');
	if (wpcode.value.trim().length==0) {
		alert('The welfare organisation\'s postal code is required.');
		wpcode.focus();
		return;
	}
	
	var wcity = document.getElementById('wel_city');
	if (wcity.value.trim().length==0) {
		alert('The welfare organisation\'s city is required.');
		wcity.focus();
		return;
	}

	var wcountry = document.getElementById('wel_country');
	if (wcountry.value.trim().length==0) {
		alert('The welfare organisation\'s country is required.');
		wcountry.focus();
		return;
	}

	var fname = document.getElementById('wel_contact_fullname');
	if (fname.value.trim().length==0) {
		alert('The welfare organisation\'s contact person\'s name is required.');
		fname.focus();
		return;
	}
	
	var cellphone = document.getElementById('wel_contact_mobile_number');
	if (cellphone.value.trim().length==0) {
		alert('The welfare organisation\'s contact person\'s cellphone number is required.');
		cellphone.focus();
		return;
	}
	
	var telephone = document.getElementById('wel_contact_number');
	if (telephone.value.trim().length==0) {
		alert('The welfare organisation\'s contact person\'s landline number is required.');
		telephone.focus();
		return;
	}
		
	document.frmAddwelfare.submit();
}

$(function() {
  $( document ).tooltip({tooltipClass: "toolTipStyling"});
});