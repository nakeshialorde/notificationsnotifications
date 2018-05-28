<?php
require 'includes/header.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>COB Admin</title>
	<link rel="stylesheet" type="text/css" href='css/style.css'>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://use.fontawesome.com/5db033aace.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="js/summarymonth.js"></script>
</head>
<body>
	<div id="pageContainer">
		<div id="topBar">
			<?php include 'includes/topbar.php'; ?>
		</div>
		<div id="body">
			<div id="menuBar">
				<?php include 'includes/menu.php'; ?>
			</div>
			<div id="content">
				<div id="contentHeader">
					Monthly Summary
				</div>
				<div id="contentBody">
					<p>Please enter a year and month below.</p>
					<p>
						<input type="number" id="year" name="year" placeholder="Year [YYYY]" /><br/><br/>
						<input type="number" id="month" name="month" placeholder="Month [1-12]" />
					</p>
				</div>
				<div id="buttonBar">
					<span id="viewReportButton" class="viewReportButton">View</span>
					<span id="downloadReportButton" class="downloadReportButton">Download</span>
				</div>
			</div>
		</div>
	</div>
</body>
</html>