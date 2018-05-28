$(function(){
	$("#userMenu").click(function(){
		$(this).toggleClass("active");
	});

	$(".collapsible").click(function(){
		$("ul", this).slideDown(300);
		$(this).siblings().find("ul").slideUp(400);
	});
});