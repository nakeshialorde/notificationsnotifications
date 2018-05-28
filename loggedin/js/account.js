$(function(){
	$("#viewReportButton").click(function(){
		if($("#accountNumber").val().length>0){
			var accountNumber = $("#accountNumber").val();
			location="https://cobadmin.azurewebsites.net/loggedin/transfersbyaccount.php?accountNumber="+accountNumber;
		}
	});
});