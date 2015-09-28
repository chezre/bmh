function validate() {
	var rfid = document.getElementById('pet_rfid');
		
	if (rfid.value.trim().length==0) {
		alert('Please insert the microchip number');
		rfid.focus();
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