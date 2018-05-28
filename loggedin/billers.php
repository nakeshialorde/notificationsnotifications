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
	 
	<script src="js/menu.js"></script>
	<script src="js/billers.js"></script>
	<script>
		var token = "<?php echo $_SESSION["token"]; ?>";
	</script>
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
					Transfers By Biller
				</div>
				<div id="contentBody">
					<p>Please select a biller.</p>
					<div class="listHeader">Billers</div>
					<div id="billerList" class="itemList"></div>
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