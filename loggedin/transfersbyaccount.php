<?php
require 'includes/header.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>COB Admin</title>
	<link rel="stylesheet" type="text/css" href='css/style.css'>
	<link rel="stylesheet" type="text/css" href='css/transfersbymember.css'>
	<script src="https://use.fontawesome.com/5db033aace.js"></script>
	<script
	  src="https://code.jquery.com/jquery-3.2.1.js"
	  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	  crossorigin="anonymous">
	</script>
	<script>
		var token = "<?php echo $_SESSION["token"]; ?>";
		var accountNumber="<?php echo $_GET["accountNumber"]; ?>";
	</script>
	<script src="js/menu.js"></script>
	<script src="js/transfersbyaccount.js"></script>
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
					Tansfers By Account
				</div>
				<div id="contentBody">
					<div id="transferListHeader" class="listHeader">
						<div class="created">Date</div>
						<div class="transferID">Txn ID</div>
						<div class="sourceAccountNumber">Src Acct</div>
						<div class="transferDescription">Description</div>
						<!--<div class="serviceName">Service</div>-->
						<!--<div class="billerID">Biller ID</div>-->
						<div class="billerTransactionID">Biller Txn ID</div>
						<div class="billerAccountNumber">Biller Acct</div>
						<div class="transferAmount">Amount</div>
						<div class="status">Status</div>
					</div>
					<div id="transferList">
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>