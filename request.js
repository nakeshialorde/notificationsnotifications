$(function(){
	$("#recipientInfoType").change(function(){
		var val = $(this).val();
		if(val=="EmailAddress"){
			$(".recipientOption").not("#thirdPartyEmailAddressControl").hide();
			$("#thirdPartyEmailAddressControl").show();
		}
		else if(val=="AccountNumber"){
			$(".recipientOption").not("#thirdPartyAccountNoControl").hide();
			$("#thirdPartyAccountNoControl").show();
		}
		else{
			$(".recipientOption").not("#myAccountControl").hide();
			$("#myAccountControl").show();
		}
	});

	$(".recipientOption").not("#thirdPartyEmailAddressControl").hide();
});

function Cancel(){
	$(".cancelButton")
		.text("Cancelling ")
		.append(
			$("<i></i>")
				.addClass("fa fa-refresh fa-spin")
		);

	window.location = "home.php";
}

function SubmitForm() {
  var RequestedAmount = $("#RequestedAmount").val();
	RequestedAmount = RequestedAmount * 1;
	if(RequestedAmount<=0){
		$("<div></div>")
			.addClass("error")
			.text("Amount must be more than 0.")
			.appendTo("#errorBar");

		return;
	}

	$("#requestSubmit.enabled")
		.removeClass("enabled")
		.text("Processing ")
		.append(
			$("<i></i>")
				.addClass("fa fa-refresh fa-spin")
		);
	$("#requestForm").submit();
}
