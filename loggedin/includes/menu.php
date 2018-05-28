<?php
	$menu = "<ul id='mainMenu' class='menu'>" .
		"<li class='collapsible'><span class='menuHeader'><i class='fa fa-tachometer' aria-hidden='true'></i>Dashboard</span>" .
			"<ul>" .
				"<li><a href='index.php'> Home </a></li>" .
			"</ul>" .
		"</li>".
		"<li class='collapsible'><span class='menuHeader'><i class='fa fa-check-circle' aria-hidden='true'></i>Reviews</span>" . 
			"<ul>" . 
				"<li><a href='allreviews.php'>All</a></li>" .
				"<li><a href='pendingreviews.php'>Pending</a></li>" . 
				"<li><a href='approvedreviews.php'>Approved</a></li>" . 
			"</ul>" . 
		"</li>" .
		"<li class='collapsible'><span class='menuHeader'><i class='fa fa-exchange' aria-hidden='true'></i>Transfers</span>" .
			"<ul>" .
				"<li><a href='billers.php'>By Biller</a></li>" .
				"<li><a href='members.php'>By Member</a></li>" .
				"<li><a href='account.php'>By Account</a></li>" .
			"</ul>" .
		"</li>" .
		"<li class='collapsible'><span class='menuHeader'><i class='fa fa-calendar' aria-hidden='true'></i>Summaries</span>" .
			"<ul>" .
				"<li><a href='summarydate.php'>Daily</a></li>" .
				"<li><a href='summarymonth.php'>Monthly</a></li>" .
				"<li><a href='summaryyear.php'>Yearly</a></li>" .
			"</ul>" .
		"</li>".
		"<li class='collapsible'><span class='menuHeader'><i class='fa fa-user' aria-hidden='true'></i>Users</span>" .
			"<ul>" .
				"<li><a href='grantuseraccess.php'> Grant User Access </a></li>" .
				"<li><a href='manageusers.php'> Manage Users </a></li>" .
			"</ul>" .
		"</li>".
	"</ul>";
	
	echo $menu;
?>