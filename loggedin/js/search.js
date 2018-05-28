
	$(document).ready(function(){
        $("#filterTerm").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("[id$=List] .listItem").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        });