<?php
	echo " <span id='logo'></span><span id='siteTitle'><a href='index.php'>COB Administrator Portal</a></span>";
	echo "<span id='userInfo'>" .
		"<ul id='userMenu' class='topmenu'>" .
			"<li>  <i class='fa fa-user-circle' aria-hidden='true'></i> " . $_SESSION["fullName"] . "" .
				//"<ul>" .
				//	"<li><a href='logout.php'>Log Out</a></li>" .
				//"</ul>" .
			"</li>" .			
		"</ul>" .
		"<ul id='userMenu' class='topmenu'>".
		"<li><a href='logout.php'> <i class='fa fa-sign-out' aria-hidde='true'></i> Log Out</a> </li>".
		"</ul>".
	"</span>";
?>


<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.5.4/src/loadingoverlay.min.js"> </script>
<script>
	//Add Ajax Loader to all pages with Ajax functions
	/*$(document).ajaxSend(function(event, jqxhr, settings){
		$.LoadingOverlay("show");
	});
	$(document).ajaxComplete(function(event, jqxhr, settings){
		$.LoadingOverlay("hide");
	});
	$(document).ajaxError(function(event, jqxhr, settings){
		$.LoadingOverlay("hide");
	});*/

	$(document).ajaxSend(function(event, jqxhr, settings){
		$("#loadingOverlay").LoadingOverlay("show");
	});
	$(document).ajaxComplete(function(event, jqxhr, settings){
		$("#loadingOverlay").LoadingOverlay("hide");
	});
	$(document).ajaxError(function(event, jqxhr, settings){
		$("#loadingOverlay").LoadingOverlay("hide");
	});

	//If ajax loader doesn't hide after 10 seconds hide it
	setTimeout(function(){ $("#loadingOverlay").LoadingOverlay("hide"); }, 10000);
</script>

<script src="js/menu.js"></script>

<div id="loadingOverlay"> </div>