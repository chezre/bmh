function validate() {
	
	var rfid = document.getElementById('pet_rfid');
	if (rfid.value.trim().length==0) {
		alert('The RFID is required to register a new pet.');
		rfid.focus();
		return;
	}
	if (isNaN(rfid.value.trim())||rfid.value.trim().length!=15) {
		alert('The RFID is not in the correct format');
		rfid.focus();
		return;
	}
	/*
	var petName = document.getElementById('pet_name');
	if (petName.value.trim().length==0) {
		alert('The pet\'s name is required to register a new pet');
		petName.focus();
		return false;
	}*/
	
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
	
	document.frmAddrfid.submit();
}