$(function(){
	$("#viewReportButton").click(function(){
		var summaryYear = $("#year").val();
		if(summaryYear.length>0){
			window.open("https://cobadmin.azurewebsites.net/loggedin/yearlysummary.php?transferYear="+summaryYear);
		}
	});
});