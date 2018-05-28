<?php
	session_destroy();
	echo "Logging you out...";
	header("Location: https://cobadmin.azurewebsites.net/");
?>