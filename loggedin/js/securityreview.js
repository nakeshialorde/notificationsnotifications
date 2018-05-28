var accountsLoaded = false;
var reviewDataLoaded = false;
var reviewData = {};
$(function(){	
	if(typeof reviewId !='undefined'){
		//console.log("inside COBSecurityReviews ajax call");
		$.ajax({
			url:"https://e-solutionsgroup.com:8080/api/COBSecurityReviews/"+reviewId,
			crossDomain:true,
			dataType:'json',
			cache:false,
			contentType:"application/json; charset=utf-8",
			beforeSend:function(xhr){
				xhr.setRequestHeader("Authorization","Bearer "+token);
			},
			success:function(data){
				reviewData = data;
				reviewDataLoaded = true;
				if(accountsLoaded){
					ApplyReviewData();
				}
				revieweeId = data.COBSecurityReview.RevieweeID;
				GetReviewDetails(revieweeId);
			}
		});
		
	}
	
	if(revieweeId.length>0){
		GetReviewDetails(revieweeId);
	}
	
	$("body").on("click","span.submitReviewButton",function(){
		var accountId = $(this).attr("data-accountid");
		var revieweeId = $(this).attr("data-revieweeId");
		var statusDescription = $("input[data-accountid='"+accountId+"']").val();
		var reviewStatus = $("select[data-accountid='"+accountId+"']").val();
		
		if(reviewStatus.length==0){
			return;
		}
		
		var data = {
			RevieweeID:revieweeId,
			Status:reviewStatus,
			StatusDescription:statusDescription,
			AssociatedAccountIDs:[
				accountId
			]
		};
		
		var dataString = JSON.stringify(data);
		//console.log(dataString);
		
		$.ajax({
			url:"https://e-solutionsgroup.com:8080/api/COBSecurityReviewsLight",
			type:"POST",
			crossDomain:true,
			dataType:'json',
			data:JSON.stringify(data),
			cache:false,
			contentType:"application/json; charset=utf-8",
			beforeSend:function(xhr){
				xhr.setRequestHeader("Authorization","Bearer "+token);
				$("span.submitReviewButton").removeClass("submitReviewButton").addClass("submitReviewButtonWorking");
			},
			success:function(data){
				alert(data.AssociatedAccounts.length+" Account(s) Updated");
			},
			complete:function(xhr,statusCode){
				$("span.submitReviewButtonWorking").addClass("submitReviewButton").removeClass("submitReviewButtonWorking");
			},
			error:function(xhr,errorType,exObj){
				alert("Error: "+errorType);
			}
		});
	});
});

function GetReviewDetails(revieweeId){
	//console.log("Inside function GetReviewDetails");
	
	$.ajax({
		url:"https://e-solutionsgroup.com:8080/api/Account/UserInfo?userId="+revieweeId,
		crossDomain:true,
		dataType:'json',
		cache:false,
		contentType:"application/json; charset=utf-8",
		beforeSend:function(xhr){
			xhr.setRequestHeader("Authorization","Bearer "+token);
		},
		success:function(data){
			$(".infoField.firstname").text(data.FirstName);
			$(".infoField.lastname").text(data.LastName);
			$(".infoField.email").text(data.Email);
		}
	});
	
	$.ajax({
		url:"https://e-solutionsgroup.com:8080/api/COBSecurityResponses?userId="+revieweeId,
		crossDomain:true,
		dataType:'json',
		cache:false,
		contentType:"application/json; charset=utf-8",
		beforeSend:function(xhr){
			xhr.setRequestHeader("Authorization","Bearer "+token);
		},
		success:function(data){
			for(i=0;i<data.length;i++){
				//console.log(data);
				$("<div></div>")
					.addClass("securityQuestionResponse")
					.attr("Account-PendingUsersId",data[i].id)
					.append(
						$("<div></div>")
							.addClass("securityQuestion")
							.append(
								$("<span></span>")
									.addClass("securityQuestionLabel")
									.text("Question"),
								$("<span></span>")
									.addClass("securityQuestionText")
									.text(data[i].QuestionText)
							),
						$("<div></div>")
							.addClass("securityResponse")
							.append(
								$("<span></span>")
									.addClass("securityResponseLabel")
									.text("Response"),
								$("<span></span>")
									.addClass("securityResponseText")
									.text(data[i].ResponseText)
							)
					)
					.appendTo("#securityQuestionResponseList");
			}
		}
	});
	
	$.ajax({
		url:"https://e-solutionsgroup.com:8080/api/AssociatedAccounts?userId="+revieweeId,
		crossDomain:true,
		dataType:'json',
		cache:false,
		contentType:"application/json; charset=utf-8",
		beforeSend:function(xhr){
			xhr.setRequestHeader("Authorization","Bearer "+token);
		},
		success:function(data){
			//console.log("Account#1:"+data[0].QuestionText);
			for(i=0;i<data.length;i++){
				$("<div></div>")
					.addClass("associatedAccount")
					.attr("associatedAccountId",data[i].AssociatedAccountID)
					.append(
						$("<div></div>")
							.addClass("accountType")
							.text(data[i].AccountType),
						$("<div></div>")
							.addClass("accountNumber")
							.text(data[i].AccountNumber),
						$("<div></div>")
							.addClass("reviewStatus")
							.append(
								$("<select></select>")
									.addClass("reviewStatusDropdown")
									.attr("data-accountid",data[i].AssociatedAccountID)
									.append(
										$("<option></option>")
											.attr("value","")
											.text("Select One"),
										$("<option></option>")
											.attr("value","Approved")
											.text("Approved"),
										$("<option></option>")
											.attr("value","Denied")
											.text("Denied")
									)
							),
						$("<div></div>")
							.addClass("reviewStatusDescription")
							.append(
								$("<input />")
									.addClass("reviewStatusDescriptionTextbox")
									.attr("data-accountid",data[i].AssociatedAccountID)
									.attr("placeholder","Description")
							),
						$("<div></div>")
							.addClass("submitReview")
							.append(
								$("<span></span>")
									.addClass("submitReviewButton")
									.attr("data-accountid",data[i].AssociatedAccountID)
									.attr("data-revieweeId",revieweeId)
									.text("Submit")
							)
					)
					.appendTo("#associatedAccountList");
			}
			accountsLoaded = true;
			if(reviewDataLoaded){
				ApplyReviewData();
			}
		}
	});
}

function ApplyReviewData(){
	console.log(reviewData);
	for(i=0;i<reviewData.AssociatedAccounts.length;i++){
		var account = reviewData.AssociatedAccounts[i];
		//if(account.Verified.length>0){
		if(account.Status === "Active"){ //account.Verified is returning NULL so I used the Status Active instead to get the correct status *FH 
			$("option[value='Approved']","select[data-accountid='"+account.AssociatedAccountID+"']").attr("selected","true");
		}
		$("input.reviewStatusDescriptionTextbox[data-accountid='"+account.AssociatedAccountID+"']").val(reviewData.COBSecurityReview.StatusDescription);
	}
}