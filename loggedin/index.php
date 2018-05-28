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
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script>
		var token = "<?php echo $_SESSION["token"]; ?>";
	</script>
	<script src="js/menu.js"></script>
	<script src="js/index.js"></script>
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
					Dashboard
				</div>
				<div id="contentBody">
					<div class="chartRow">
						<div id="billerTransferTotalsChart" class="chart"></div>
						<div id="billerTransferFundsTotalsChart" class="chart"></div>
					</div>
					<div class="chartRow">
						<div id="billerTransferTotalsByYearChart" class="chart"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>