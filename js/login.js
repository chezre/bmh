$(document).ready(function() {
	/*$('input').keypress(function(e) {
        if(e.which == 13) {
            $("#frmLogin").submit();
        }
    });*/
    $("#imgSubmit").click(function() {
    	$("#submit").click();
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
	
	var pword = document.getElementById('usr_password');
	if (pword.value.trim().length==0) {
		alert('The password is required to login.');
		pword.focus();
		return false;
	}
	return true;
}