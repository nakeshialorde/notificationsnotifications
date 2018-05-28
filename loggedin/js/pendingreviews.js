$(function(){
	$.ajax({
		url:"https://e-solutionsgroup.com:8080/api/Account/PendingUsers",
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
					.addClass("PendingUsers listItem")
					.attr("Account-PendingUsersId",data[i].id)
					.append(
						$("<div></div>")
							.addClass("FullName")
							.append(
								$("<a></a>")
									.attr("href","https://cobadmin.azurewebsites.net/loggedin/securityreview.php?revieweeid="+data[i].Id)
									.text(data[i].FirstName+" "+data[i].LastName)
							),
						$("<div></div>")
							.addClass("LastLogin")
							.text(data[i].LastLogin),
						$("<div></div>")
							.addClass("Email")
							.text(data[i].Email),
						$("<div></div>")
							.addClass("PhoneNumber")
							.text(data[i].PhoneNumber)
					)
					.appendTo("#PendingUsersList");
			}
		}
	});
});