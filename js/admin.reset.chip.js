var currentPage = 1;
$(document).ready(function() {
	$("#saveResult").hide();
	$("#btnSearch").bind("click",findChip);
	$("#pet_rfid").keyup(function(e){
		var code = e.which; // recommended to use e.which, it's normalized across browsers
    	if(code==13) e.preventDefault();
    	if(code==32||code==13||code==188||code==186){
			currentPage = 1;
        	findChip();
		} 
	});
});

function findChip(){
	$("#searchDiv").val('');
	$("#saveResult").hide();
	var chip = $("#pet_rfid").val();
	
	if (chip.length==0) {
		alert('Please insert the microchip number');
		$("#pet_rfid").focus();
		return;
	}
	$("#searchResult").empty().append('searching for chip...').show();
	$.get("get.microchip.php",{pet_rfid: chip,resetChip: 'Y'}).done(function(data){
		$("#searchResult").empty().append(data).show();
	});
}
function resetChip(){
	$("#searchDiv").val('');
	$("#saveResult").hide();
	var chip = $("#pet_rfid").val();
	$("#searchResult").empty().append('resetting chip...').show();
	$.post("admin.save.reset.chip.php",{pet_rfid: chip}).done(function(data){
		var json = $.parseJSON(data);
		$("#searchResult").empty().append(json.message).show();
	});
}