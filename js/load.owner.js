$(document).ready(function(){
	$("#addPetDiv").click(function(){
		addPet();
	});
	$("#pet_rfid").keypress(function (event) {
        if(event.keyCode == 13) {
			event.preventDefault;
			return false;
		}
	});
});

function showImage(img,primaryImgId){
	var i =	document.getElementById(primaryImgId);
	i.src = img.src;
}
function addPet() {
	if (isNaN($("#pet_rfid").val())||$("#pet_rfid").val().length<10) {
		alert("The microchip number you have entered is invalid.  Please check the number you have inserted");
		$("#pet_rfid").focus();
		return;
	}
	
	var rfid = $("#pet_rfid").val();
	var sbmt = true;
	$.post( "script.check.rfid.php", {pet_rfid: rfid}).done(function (data) {
		var obj = jQuery.parseJSON( data );
		if (obj.exists=='N') {
			alert('Microchip number does not exist.');
			sbmt = false;
		}
		if (obj.alreadyRegistered=='Y') {
			alert('Microchip number has already been registered.');
			sbmt = false;
		}
		
		console.log(data);
		if (!sbmt) {
			$("#pet_rfid").focus();
			return;
		}
		document.frmAddPet.submit();
	});
}