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
		alert('The chip number is required to add a pet.');
		rfid.focus();
		return;
	}
	
	if (rfid.value.trim().length<15) {
		alert('The chip number you entered is too short. Please check that you have entered it correctly');
		rfid.focus();
		return;
	}
	
	if (isNaN(rfid.value.trim())) {
		alert('Only numeric characters allowed in the RFID field');
		rfid.focus();
		return;
	}
	
	var vetId = document.getElementById('pet_assigned_by_usr_id');
	if (typeof(vetId) != 'undefined' && vetId != null)
	{
		if (vetId.value.trim().length==0) {
			alert('The Vet\'s name is required.');
			vetId.focus();
			return;
		}
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
	if (typeof(petName) != 'undefined' && petName != null)
	{
		if (petName.value.trim().length==0) {
			alert('The Pet\'s name is required.');
			petName.focus();
			return;
		}
	}
	
	var petSpecies = document.getElementById('pet_species'); 
	if (typeof(petSpecies) != 'undefined' && petSpecies != null)
	{
		if (petSpecies.value.trim().length==0) {
			alert('The Pet\'s species is required.');
			petSpecies.focus();
			return;
		}
	}
	
	var petColour = document.getElementById('pet_colour'); 
	if (typeof(petColour) != 'undefined' && petColour != null)
	{
		if (petColour.value.trim().length==0) {
			alert('The Pet\'s colour is required.');
			petColour.focus();
			return;
		}
	}
	
	var petBreed = document.getElementById('pet_breed'); 
	if (typeof(petBreed) != 'undefined' && petBreed != null)
	{
		if (petBreed.value.trim().length==0) {
			alert('The Pet\'s breed is required.');
			petBreed.focus();
			return;
		}
	}
	var petWeight = document.getElementById('pet_weight'); 
	if (isNaN(petWeight.value.trim())) {
		alert('The Pet\'s weight must only contain numeric values.');
		petWeight.focus();
		return;
	}
	
	document.frmEditpet.submit();
}

function validateTrf() {
	var email = document.getElementById('trfEmail');
	if (email.value.trim().length==0) {
		alert('The email address is required to transfer this pet.');
		email.focus();
		return;
	}
	
	if (email.value.trim().indexOf('@')==-1||email.value.trim().indexOf('.')==-1) {
		alert('Email address is invalid');
		email.focus();
		return;
	}
	document.frmTransfer.submit();		
}

function confirmStatusUpdate() {
 	var newStatus = document.getElementById('pet_status');
 	var oldStatus = document.getElementById('old_status');
	var r=confirm("Are you sure you want to update the status from " + oldStatus.value + " to " + newStatus.value);
	if (r==true) {
		oldStatus.value = newStatus.value;
	}
	else
	{
		newStatus.value = oldStatus.value;
	}
}

function removePhoto(imgFlag,prvElId,el) {
    document.getElementById(imgFlag).value = '';
    document.getElementById(prvElId).style.display = 'none';
    el.style.display = 'none';
}

function removeFreeImage() {
    document.getElementById('pet_photo_1').value = '';
    document.getElementById('divPreviewFree').style.display = 'none';
}

function showPreviewFree(el) {
    var fileNameIndex = el.src.lastIndexOf("/") + 1;
    var filename = el.src.substr(fileNameIndex);
    var cnfm = true;
    if (document.getElementById('pet_photo_1').value.trim().length>0&&document.getElementById('pet_photo_1').value.indexOf("img")<0) {
        cnfm = confirm('Are you sure you want to replace the current image?  Click Ok to confirm.');  
    } 
    if (cnfm) {
        document.getElementById('pet_photo_1').value = 'img/' + filename;
        document.getElementById('imgPreviewFree').src = 'img/' + filename;
        var previewEl = document.getElementById('divPreviewFree');
        previewEl.style.display = '';
    }
}

function isHorse(el) {
	document.getElementById('heightRow').style.display = (el.value=='horse') ? '':'none';
}