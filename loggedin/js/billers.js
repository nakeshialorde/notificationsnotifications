$(function(){
	$("body").on("click",".biller",function(){
		$(".biller").not(this).removeClass("selected");
		$(this).toggleClass("selected");
	});
	$("#viewReportButton").click(function(){
		if($(".biller.selected").length>0){
			var id = $(".biller.selected").attr("billerId");
			location="https://cobadmin.azurewebsites.net/loggedin/transfersbybiller.php?id="+id;
		}
	});
	$.ajax({
		url:"https://e-solutionsgroup.com:8080/api/Billers",
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
					.addClass("listItem biller")
					.attr("billerId",data[i].BillerID)
					.append(
						$("<div></div>")
							.addClass("displayName")
							.text(data[i].DisplayName)
					)
					.appendTo("#billerList");
			}
		}
	});
});