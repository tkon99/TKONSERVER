/*(c) by Thomas Konings*/
$(document).ready(function(){
	$("#kills-table").show();
});

function showRanking(which){
	$("#kills-table").hide();
	$("#headshot-table").hide();
	$("#teamkill-table").hide();
	$("#"+which+"-table").show();
}