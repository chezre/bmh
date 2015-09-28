$(function() {
    $( "#pet_birthdate, #pet_implanted_date" ).datepicker({
		dateFormat: 'yy-mm-dd'	
	});
  });

function showPreview(frmElId,prvElId) {
	 document.getElementById(prvElId).style.display = '';
	var oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById(frmElId).files[0]);
	
	oFReader.onload = function (oFREvent) {
	    document.getElementById(prvElId).src = oFREvent.target.result;
	};
}
function validate() {
	var rfid = document.getElementById('pet_rfid');
	if (rfid.value.trim().length==0) {
		alert('The Chip number is required to add a pet.');
		rfid.focus();
		return false;
	}
	
	if (rfid.value.trim().length<15) {
		alert('The Chip number you entered is too short. Please check that you have entered it correctly');
		rfid.focus();
		return false;
	}
	
	if (isNaN(rfid.value.trim())) {
		alert('Only numeric characters allowed in the RFID field');
		rfid.focus();
		return false;
	}
	
	var petImplantDate = document.getElementById('pet_implanted_date'); 
	if (typeof(petImplantDate) != 'undefined' && petImplantDate != null)
	{
		if (petImplantDate.value.trim().length==0) {
			alert('The date the microchip was implanted is required.');
			petImplantDate.focus();
			return;
		}
	}
	var petName = document.getElementById('pet_name'); 
	if (petName.value.trim().length==0) {
		alert('The Pet\'s name is required.');
		petName.focus();
		return false;
	}
	
	var petSpecies = document.getElementById('pet_species'); 
	if (petSpecies.value.trim().length==0) {
		alert('The Pet\'s species is required.');
		petSpecies.focus();
		return false;
	}
	
	var petBreed = document.getElementById('pet_breed'); 
	if (petBreed.value.trim().length==0) {
		alert('The Pet\'s breed is required.');
		petBreed.focus();
		return false;
	}
	
	var petWeight = document.getElementById('pet_weight'); 
	if (isNaN(petWeight.value.trim())) {
		alert('The Pet\'s weight must only contain numeric values.');
		petWeight.focus();
		return false;
	}
	
	return true;
}