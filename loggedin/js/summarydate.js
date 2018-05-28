$(function(){
	$( "#datepicker" ).datepicker();
	$("#viewReportButton").click(function(){
		var summaryDate = $("#datepicker").val();
		if(summaryDate.length>0){
			window.open("https://cobadmin.azurewebsites.net/loggedin/dailysummary.php?transferDate="+summaryDate);
		}
	});
});