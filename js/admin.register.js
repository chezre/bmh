$(document).ready(function() {
	$("#btnSearch").bind("click",loadRfid);
	$("#rfid").keyup(function(e){
		var code = e.which; // recommended to use e.which, it's normalized across browsers
    	if(code==13)e.preventDefault();
    	if(code==32||code==13||code==188||code==186){
        	loadRfid();
		} 
	});
	$(".liSteps").click(function(){
		$("#currentForm").empty().append('loading...').show();
		var e = $(this).attr('get');
		$.get('get.'+e+'.php',{rfid: $("#rfid").val(),pet_id: $("#pet_id").val(),pow_usr_id: $("#pow_usr_id").val()}).done(function(data){
			$("#currentForm").empty().append(data).show();
		});
	});
});
function loadRfid() {
	$("#currentForm").empty().append('loading...');
	$.get("get.progress.php",{rfid: $("#rfid").val()}).done(function(data){
		var json = $.parseJSON(data);
		if (json.error=='N') {
			$("#searchResult").hide();
			$("#chipDiv").hide();
			var dv = '<div class="'+json.status+'">registration: '+json.status+'</div>';
			$("#headingDiv").empty().append(json.rfid+dv);
			$("#imgStep1").attr('src','img/'+json.srcStep1+'.png');
			$("#imgStep2").attr('src','img/'+json.srcStep2+'.png');
			$("#imgStep3").attr('src','img/'+json.srcStep3+'.png');
			$("#pet_id").val(json.pet_id);
			$("#pow_usr_id").val(json.pow_usr_id);
			if (json.click.length==0){
				$("#currentForm").hide();
			} else {
				$("#"+json.click).click();
			}
			$("#formWrapper").show();	
		} else {
			$("#searchResult").empty().append(json.message).show();
		}
	});
	
}