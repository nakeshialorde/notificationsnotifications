$(function(){
	$("body").on("click",".listItem",function(){
		$(".listItem").not(this).removeClass("selected");
		$(this).toggleClass("selected");
	});
	$("#viewReportButton").click(function(){
		if($(".member.selected").length>0){
			var id = $(".member.selected").attr("memberid");
			location="https://cobadmin.azurewebsites.net/loggedin/transfersbymember.php?id="+id;
		}
	});
	$.ajax({
		url:"https://e-solutionsgroup.com:8080/api/Account/UsersBySourceInstitution?institutionId=8DB34F14-A886-4BDB-AC85-2351CDD0F715",
		crossDomain:true,
		dataType:'json',
		cache:false,
		contentType:"application/json; charset=utf-8",
		beforeSend:function(xhr){
			xhr.setRequestHeader("Authorization","Bearer "+token);
		},
		success:function(data){
			console.log(data);
			for(i=0;i<data.length;i++){
				$("<div></div>")
					.addClass("listItem member")
					.attr("memberid",data[i].Id)
					.append(
						$("<div></div>")
							.addClass("lastName")
							.text(data[i].LastName),
						$("<div></div>")
							.addClass("firstName")
							.text(data[i].FirstName),
						$("<div></div>")
							.addClass("email")
							.text(data[i].Email)
					)
					.appendTo("#memberList");
			}
		}
	});
});