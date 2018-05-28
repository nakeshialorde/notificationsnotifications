$(function(){
	$("#viewReportButton").click(function(){
		var summaryYear = $("#year").val();
		var summaryMonth = $("#month").val();
		if(summaryYear.length>0 && summaryMonth.length>0){
			window.open("https://cobadmin.azurewebsites.net/loggedin/monthlysummary.php?transferYear="+summaryYear+"&transferMonth="+summaryMonth);
		}
	});
});