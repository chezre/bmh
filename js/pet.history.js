function loadNewReport() {
	document.frmSearch.submit();
}
function showImage(img,primaryImgId){
	var i =	document.getElementById(primaryImgId);
	i.src = img.src;
}
function validate() {
 	var d = document.getElementById('decision');
	var c = confirm('Are you sure you want to ' + d.value.replace('ed','') + ' the pet transfer');
	if (c) document.frmSearch.submit();
}