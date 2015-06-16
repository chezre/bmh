function validate() {
	
	var fname = document.getElementById('vet_name');
	if (fname.value.trim().length==0) {
		alert('Your full name is required.');
		fname.focus();
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
		
	document.frmEditvet.submit();
}