var currentPage = 1;
$(document).ready(function() {
	$("#saveResult").hide();
	$("#btnSearch").bind("click",findVets);
	$("#srch_value").keyup(function(e){
		var code = e.which; // recommended to use e.which, it's normalized across browsers
    	if(code==13) e.preventDefault();
    	if(code==32||code==13||code==188||code==186){
        	findVets();
		} 
	});
});
function findVets() {
	$("#saveResult").hide();
	$("#searchResult").empty().append('loading...').show();
	$.get("get.searched.vets.php",{pg: currentPage,srch_value: $("#srch_value").val()}).done(function(data){
		$("#headingDiv").empty().append("Search Results");
		$("#searchResult").empty().append(data).show();
	});
}
function editVet(vid){
	$("#searchDiv").val('');
	$("#saveResult").hide();
	$("#searchResult").empty().append('loading...').show();
	$.get("get.vet.php",{vet_id: vid}).done(function(data){
		$("#headingDiv").empty().append("Edit VET");
		$("#searchResult").empty().append(data).show();
	});
}