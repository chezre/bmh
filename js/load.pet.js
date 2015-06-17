$(document).ready(function(){
	$(".btnYes").click(function(){
		var pId = $("#pId").val();
		$("#certMsg").empty().append('sending certificate...');
		$(".btnYes, .btnNo").hide();
		$.post("script.send.certificate.php",{pet_id: pId})
			.done(function( data ) {
    			location.reload();
			});
	});
	$(".btnNo").click(function(){
		editPet();
	});
	$("#btnEditPet").click(function(){
		editPet();
	});
});

function editPet() {
	var pId = $("#pId").val();
	window.location.replace("edit.pet.php?p="+pId);
}