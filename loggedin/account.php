<?php
require 'includes/header.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>COB Admin</title>
	<link rel="stylesheet" type="text/css" href='css/style.css'>
	<script src="https://use.fontawesome.com/5db033aace.js"></script>
	<script
	  src="https://code.jquery.com/jquery-3.2.1.js"
	  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	  crossorigin="anonymous">
	</script>
	<script>
		var token = "<?php echo $_SESSION["token"]; ?>";
	</script>
	<script src="js/menu.js"></script>
	<script src="js/account.js"></script>
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
					Account Number
				</div>
				<div id="contentBody">
					<p>Please enter an account number below.</p>
					<div><input type="text" id="accountNumber" name="accountNumber" /></div>
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