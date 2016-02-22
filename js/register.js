var captchaOk = false;
$(document).ready(function(){
   $("#imgSubmit").click(function(){
    
        var respText = $("textarea[name='g-recaptcha-response']").val();
        event.preventDefault();
		if (captchaOk) {
			validate();
			return;
		}
		$.post(
			'verify.captcha.php',{'g-recaptcha-response': respText}
		).done(function (data) {
		    var resp = $.parseJSON(data);
			captchaOk = resp.verified;
			if (!captchaOk) 
			{
				alert('Are you a robot?  Please check the box below.');
				return;
			}
			validate();
		});
   }); 
});
function validate() {
	var email = document.getElementById('usr_email');
	if (email.value.trim().length==0) {
		alert('The email address is required to login.');
		email.focus();
		return false;
	}
	
	if (email.value.trim().indexOf('@')==-1||email.value.trim().indexOf('.')==-1) {
		alert('Email address is invalid');
		email.focus();
		return false;
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
			return false;
		}
		if (pwd.value.trim().length<6) {
			alert('Your password must contain at least 6 characters');
			pwd.focus();
			return false;
		}
		if (cpwd.value.trim().length==0) {
			alert('Please confirm your password.');
			cpwd.focus();
			return false;
		}
		if (pwd.value.trim() != cpwd.value.trim()) {
			alert('Your passwords don\'t match.');
			return false;
		}
	}
	
	var fname = document.getElementById('pow_first_name');
	if (fname.value.trim().length==0) {
		alert('Your first name is required.');
		fname.focus();
		return false;
	}
	
	var lname = document.getElementById('pow_last_name');
	if (lname.value.trim().length==0) {
		alert('Your last name is required.');
		lname.focus();
		return false;
	}
	
	var cellphone = document.getElementById('pow_cellphone_no');
	var telephone = document.getElementById('pow_telephone_no');
	if (cellphone.value.trim().length==0&&telephone.value.trim().length==0) {
		alert('Your cellphone number/landline number is required.');
		return false;
	}
	
    document.frmOwnerRegister.submit();
}

$(function() {
  $( document ).tooltip({tooltipClass: "toolTipStyling"});
});