$(function() {
    $( document ).tooltip();
  });

function validate() {
	var rfid = document.getElementById('pet_rfid');
	var ownerEmail = document.getElementById('owner_email');
	var ownerName = document.getElementById('owner_name');
	
	if (rfid.value.trim().length==0 && ownerEmail.value.trim().length==0 && ownerName.value.trim().length==0) {
		alert('Please insert a value in one of the fields');
		return;
	}
	
	if (rfid.value.trim().length>0) {
		if (rfid.value.trim().length<15) {
			alert('The RFID number you entered is too short. Please check that you have entered it correctly');
			rfid.focus();
			return;
		}
		
		if (isNaN(rfid.value.trim())) {
			alert('Only numeric characters allowed in the RFID field');
			rfid.focus();
			return;
		}	
	}
	
	document.frmSearch.submit();
}