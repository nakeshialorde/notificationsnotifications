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
	<script src="js/allreviews.js"></script>
	<script src="js/search.js"></script>
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
					All Reviews
				</div>
				
				<div id="buttonBar">
						<span><input id="filterTerm" class="search" type="text" placeholder="Find reviewee in list..."></span>
				</div>

				<div id="contentBody">
					<div id="RecentlyApprovedReviewListHeader" class="listHeader">
						<div class="FullName">Full Name</div>
						<div class="LastLogin">Last Login</div>
						<div class="Email">Email</div>
						<div class="PhoneNumber">Phone Number</div>
					</div>
					<div id="ReviewList"></div> 
				</div>
			</div>
		</div>
	</div>
</body>
</html>