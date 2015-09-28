function validate() {
	
	var fname = document.getElementById('pow_first_name');
	if (fname.value.trim().length==0) {
		alert('Your first name is required.');
		fname.focus();
		return;
	}
	
	var lname = document.getElementById('pow_last_name');
	if (lname.value.trim().length==0) {
		alert('Your last name is required.');
		lname.focus();
		return;
	}
	
	var cellphone = document.getElementById('pow_cellphone_no');
	var telephone = document.getElementById('pow_telephone_no');
	if (cellphone.value.trim().length==0&&telephone.value.trim().length==0) {
		alert('Your cellphone number/landline number is required.');
		return;
	}
		
	document.frmEditowner.submit();
}

$(function() {
  $( document ).tooltip({tooltipClass: "toolTipStyling"});
});