$(document).ready( function() {
    $('.dropdown-toggle-countrycode').dropdown();
});

$(function(){
	$(".countryListItem").click(function(){
		var territoryCode = $(this).attr("data-countrycode");
		$("#territoryCode").val(territoryCode);
	});
});
