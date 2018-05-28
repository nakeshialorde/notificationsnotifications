<!DOCTYPE html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<script src="https://use.fontawesome.com/5db033aace.js"></script>
	<script
	  src="https://code.jquery.com/jquery-3.2.1.js"
	  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	  crossorigin="anonymous">
	</script>
	<script src="/js/transfer.js"></script>
<!--STYLES FOR UI UPDATE -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet" href="assets/css/modify-style.css">
<link rel="stylesheet" href="assets/css/bs-custom-theme.css">
<link rel="stylesheet" href="assets/css/custom.css">
<!-- END UI UPDATE STYLES -->

</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<ul class="nav navbar-nav">
			<!--<li><a href="javascript:window.history.back()"><i class="glyphicon glyphicon-menu-left"></i> </a></li>-->
			<li><a> Transfer Successful </a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<!--<li><a href="javascript:location.reload();"><i class="fa fa-refresh theme-color-two"></i></a></li>-->
			<li><a href="home.php"><i class="fa fa-home"></i></a></li>
			<li><a><i class="fa fa-bars" id="toggle-menu" ></i></a></li>		
		</ul>
	</div>
</nav>

<div id="main"  class="container spacer">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<div class="big-message text-center" style="background:#fff;">
                            <p><i class="fa fa-5x fa-exchange theme-color-one" aria-hidden="true"></i></p>
                            <p><h4> Transaction Successful! </h4></p>

                            <div class="well"> Your transfer completed successfully </div>
							<a href="home.php" class="btn btn-default">Home</a>
				  <a href="transfer.php" class="btn btn-success">New Transfer</a>

                            </div>
                        </div>
                </div>
</div>
</div>
</div>

<?php 
	include "partials/menu.php"; //include slideout menu 
	include "partials/footer.php";//include footer
?> 