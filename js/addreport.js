$(function() {
    $( "#vhi_date" ).datepicker({
		dateFormat: 'yy-mm-dd'	
	});
  });
$(function() {
    $( "#pet_next_vaccination_date" ).datepicker({
		dateFormat: 'yy-mm-dd'	
	});
  });

function validate() {
	var vName = document.getElementById('vhi_name');
	if (vName.value.trim().length==0) {
		alert('Please select the vaccination administered to the pet.');
		vName.focus();
		return;
	}
	
	var vDate = document.getElementById('vhi_date');
	if (vDate.value.trim().length==0) {
		alert('Please select the date that the vaccination was administered to the pet.');
		vDate.focus();
		return;
	}
	
	document.frmAddreport.submit();
}