<!DOCTYPE html>
<html class="fa-events-icons-ready">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<script src="https://use.fontawesome.com/5db033aace.js"></script><link href="https://use.fontawesome.com/5db033aace.css" media="all" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous">
	</script>
	<script src="js/notifications.js"></script>
	<!--STYLES FOR UI UPDATE -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
	<link rel="stylesheet" href="assets/css/modify-style.css">
	<link rel="stylesheet" href="assets/css/bs-custom-theme.css">
	<link rel="stylesheet" href="assets/css/custom.css">
	<!-- END UI UPDATE STYLES -->
<link href="https://unpkg.com/ionicons@4.0.0/dist/css/ionicons.min.css"rel="stylesheet"/>

<link rel="stylesheet" id="coToolbarStyle" href="chrome-extension://cjabmdjcfcfdmffimndhafhblfmpjdpe/toolbar/styles/placeholder.css" type="text/css">
<script type="text/javascript" id="cosymantecbfw_removeToolbar">(function () {				var toolbarElement = {},					parent = {},					interval = 0,					retryCount = 0,					isRemoved = false;				if (window.location.protocol === 'file:') {					interval = window.setInterval(function () {						toolbarElement = document.getElementById('coFrameDiv');						if (toolbarElement) {							parent = toolbarElement.parentNode;							if (parent) {								parent.removeChild(toolbarElement);								isRemoved = true;								if (document.body && document.body.style) {									document.body.style.setProperty('margin-top', '0px', 'important');								}							}						}						retryCount += 1;						if (retryCount > 10 || isRemoved) {							window.clearInterval(interval);						}					}, 10);				}			})();
</script>

<!--Notification plugin start-->
<link rel="stylesheet" href="css/message.css">
<script src="js/message.js"></script>
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT"
	crossorigin="anonymous">
</script>
<!--Notification plugin end-->

<style>
.navbar-nav mr-auto
{
  list-style: none;
}
</style>
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<ul class="nav navbar-nav">
			<li><a href="javascript:window.history.back()"><i class="glyphicon glyphicon-menu-left"></i> </a></li>
			<li><a>Notifications</a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<!--<li><a href="javascript:location.reload();"><i class="fa fa-refresh theme-color-two"></i></a></li>-->
							<li><a href="home.php"><i class="fa fa-home"></i></a></li>
          		<li><a><i class="fa fa-bars" id="toggle-menu"></i></a></li>
							<li><a><i class="fa fa-bars" id="toggle-menu"></i></a></li>
							<div id="message"></div>

		</ul>
	</div>
</nav>

<div class="container spacer">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	    <nav class="navbar navbar-default navbar-fixed-top" id="notifications-navbar" style="border-bottom: 0px;">
	        <div class="container">
	            <ul class="nav navbar-nav">
	                <li><a href="javascript:window.history.back()"><i class="glyphicon glyphicon-menu-left"></i> </a></li>
	                <li><a> Notifications </a></li>
	            </ul>

	            <ul class="nav navbar-nav navbar-right">
	            <li><a href="javascript:location.reload()"><i class="fa fa-refresh theme-color-two"></i></a></li>
	            <li><a href="home.php"><i class="fa fa-home"></i></a></li>
				<li><a href="#"><i class="fa fa-bars" id="toggle-menu"></i></a></li>


<!--NOTIFICATION PLUGIN BEGIN-->
<script>
MessagePlugin.init({
  elem: "#message",
  msgData: [
    {text: "New Message", id: 1, readStatus: 1},
    {text: "New Request", id: 2, readStatus: 1},
    {text: "New Message", id: 3, readStatus: 0},
    {text: "New Message", id: 4, readStatus: 0},
    {text: "New Message", id: 5, readStatus: 0},
    {text: "New Message", id: 6, readStatus: 0}],
    getNodeHtml: function(obj, node) { // custom html
      if (obj.readStatus == 1) {
          node.isRead = true;
      } else {
          node.isRead = false;
      }
      var html = "<p>"+ obj.text +"</p>";
      node.html = html;
      return node;
    }
});

MessagePlugin.init({
  // title
  title: "<a href="https://www.jqueryscript.net/tags.php?/Notification/">Notifications</a>",

  // width/height
  width: 250,
  height: 350,

  // message data
  msgData: [],

  // notice data
  noticeData: [],

  // the amount of unread messages
  msgUnReadData: 0,

  // the amount of unread notifications
  noticeUnReadData: 0,

  // the amount of messages to display
  msgShow: 5,

  // the amount of notifications to display
  noticeShow: 5

});

MessagePlugin.init({
  allRead: null
});

MessagePlugin.init({
  msgClick: null,
  noticeClick: null
});
</script>
<!--NOTIFICATION PLUGIN END-->

				<!-- NOTIFICATIONS -->
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item dropdown">
							<a class="nav-link" href="generalnotifications.php" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-fw fa-bell-o"></i>

								<?php
				                $query = "SELECT * from `cobnotifications` where `notification_status` = 'unread' order by `date` DESC";
				                if(count(fetchAll($query))
				                ?>
				                <span class="badge badge-light"><?php echo count(fetchAll($query)); ?></span>
				              <?php
				                }
				                    ?>
				              </a>

											<div class="dropdown-menu" aria-labelledby="dropdown01">
				                <?php
				                $query = "SELECT * from `cobnotifications` order by `date` DESC";
				                 if(count(fetchAll($query))>0){
				                     foreach(fetchAll($query) as $i){
				                ?>
				              <a style ="
				                         <?php
				                            if($i['status']=='unread'){
				                                echo "font-weight:bold;";
				                            }
				                         ?>
				                         " class="dropdown-item" href="view.php?id=<?php echo $i['id'] ?>">
				                <small><i><?php echo date('F j, Y, g:i a',strtotime($i['date'])) ?></i></small><br/>
				                  <?php

				                if($i['type']=='message'){
				                    echo "You have a new notification from COB Administration";
				                }else if($i['type']=='like'){
				                    echo ucfirst($i['email'])." <?php echo $_POST["message"]; ?>";
				                }

				                  ?>
				                </a>
				              <div class="dropdown-divider"></div>
				                <?php
				                     }
				                 }else{
				                     echo "No notifications yet.";
				                 }
				                     ?>
				            </div>
				          </li>
				        </ul>

				<!-- END OF NOTIFICATIONS -->
			</ul>
	        </div>

	    </nav>

	    <div class="container">

				<form id="generalnotifications" action="generalnotifications.php" method="POST">

					<li class="list-group-item list-card list-card-slim padding-top-0">
						<h6> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>&ensp; Subject </h6>
						<p><?php echo $_POST["subject"]; ?></p>
					</li>

		 <script>
		 $(document).ready(function(){

		  function load_unseen_notification(view = '')
		  {
		   $.ajax({
		    url:"fetch.php",
		    method:"POST",
		    data:{view:view},
		    dataType:"json",
		    success:function(data)
		    {
		     $('.dropdown-menu').html(data.notification);
		     if(data.unseen_notification > 0)
		     {
		      $('.count').html(data.unseen_notification);
		     }
		    }
		   });
		  }

		  load_unseen_notification();

		  $('#generalnotifications').on('submit', function(event){
		   event.preventDefault();
		   if($('#subject').val() != '' && $('#message').val() != '')
		   {
		    var form_data = $(this).serialize();
		    $.ajax({
		     url:"insert.php",
		     method:"POST",
		     data:form_data,
		     success:function(data)
		     {
		      $('#generalnotifications')[0].reset();
		      load_unseen_notification();
		     }
		    });
		   }
		   else
		   {
		    alert("Both Fields are Required");
		   }
		  });

		  $(document).on('click', '.dropdown-toggle', function(){
		   $('.count').html('');
		   load_unseen_notification('yes');
		  });

		  setInterval(function(){
		   load_unseen_notification();
		  }, 5000);

		 });
		 </script>


	    <div class="row" style="margin-top:20px;">
	            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	                      <ul id="notifications" class="list-group">
	                        <!--Notification List loads here -->
	                      <li class="list-group-item list-card unread personal">
												<p style="display:inline-block; width:85%" class="status-dot single-line">
												&ensp; &nbsp;<i class="fa fa-exclamation-circle" aria-hidden="true"></i>&ensp; Message</p>
												<a href="generalnotifications.php?message_id=43901940319414">
												<p style="width:5%; display:inline-block; float:right;">
												<span class="pull-right" style="cursor:pointer;">
												<i class="glyphicon glyphicon-menu-right theme-color-two"></i></span></p></a>
												<p class="text-light-grey"> Tap to read full notificaiton</p></li></ul>
	            </div>
	        </div>
	    </div>


	    <div id="notification-filter" style="" class="row">
	        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                    <div class="btn-group btn-group-justified secondary-link">
	                            <div class="btn-group"><button id="all" class="btn btn-sm btn-link focused"> All</button></div>
	                            <div class="btn-group"><button id="filter-personal" class="btn btn-sm btn-link"> Personal </button></div>
	                            <div class="btn-group"><button id="filter-general" class="btn btn-sm btn-link"> General </button></div>
	                            <div class="btn-group"><button id="filter-unread" class="btn btn-sm btn-link"> Unread</button></div>
	                    </div>
	            </div>
	    </div>

		</form>

	 </div>


	    <script>
	$(document).ready(function () {
	    // toggle sidebar when button clicked
	    $('#toggle-menu').click(function () {
	        $('.menu').toggleClass('open');
	        $('#menu-overlay').toggleClass('show');
	        if($('#submenu-user').hasClass("in")){
	            $('#submenu-user').removeClass('in');
	        }
	        toggleBodyScroll();
	    });
	});

	$(document).on("touchmove mouseup", function(e)
	{

	    if($('#menu').hasClass('open')){
	        //e.preventDefault();
	        var container = $(".menu");
	        //if the target of the click isn't the container,a descendant of the container or the menu icon
	        if (!container.is(e.target) && container.has(e.target).length === 0 && e.target.id != "toggle-menu")
	        {
	            container.removeClass('open');
	            $('#menu-overlay').removeClass('show');
	            toggleBodyScroll();
	        }
	    }
	});

	var currentScrollPos; //track the current window position when menu opened to avoid window reseting to top when menu closed

	function toggleBodyScroll(){
	    winPos = $(window).scrollTop();
	    if($('#menu').hasClass('open')){
	        $('body').addClass('no-scroll');
	        $('body').css('top', - winPos + 'px');
	        $('#main').addClass('fixed-content');
	        currentScrollPos = winPos;
	    }else{
	        $('body').removeClass('no-scroll');
	        $('#main').removeClass('fixed-content');
	        $(window).scrollTop(currentScrollPos);
	        //return false;
	    }
	}
	</script>

	<style>
	#toggle-menu{
	    cursor:pointer;
	}
	#menu-overlay{
	    position:fixed;
	    z-index:998;
	    display:none;
	    top:50px;
	    left:0;
	    content:" ";
	    width:100%;
	    height:100%;
	    background-color:rgba(0,0,0,0.5);
	}

	#menu-overlay.show{
	    display:block;
	}

	.menu{
	    position:fixed;
	    top:50px;
	    left:0;
	    width:250px;
	    min-width: 250px;
	    max-width: 250px;
	    padding:15px 0px 50px 0px;
	    height:100vh;
	    min-height: calc(100vh - 56px);
	    z-index:999;
	    background-color:#EAEDF2;
	    border:solid;
	    border-color:#C2CBD8;
	    border-width:0px 1px 0px 0px;
	    -webkit-box-shadow: 0px 0px 50px 0px rgba(0,0,0,0.5);
	    -moz-box-shadow: 0px 0px 50px 0px rgba(0,0,0,0.5);
	    box-shadow: 0px 0px 50px 0px rgba(0,0,0,0.5);
	    -webkit-transform: translateX(-250%);
				transform: translateX(-250%);
		transition: transform 200ms linear;
	    will-change: transform;
	    overflow-y:auto;
	}

	.menu.open{
	    -webkit-transform: none;
	            transform: none;
	    transition: transform 200ms linear;
	}

	.menu ul li a {
	    display: block;
	    padding: 1.5rem 1.2rem 1.5rem 2.5rem;
	    color: #374355;
	    text-decoration: none;
	}

	.menu ul li a:focus{
	    background-color: rgba(0,0,0,0.07);
	}
	.menu ul li a:hover, .menu ul .active a {
	    color: #374355;
	}

	.menu ul ul a {
	    padding-left:5.5rem;
	}

	.menu [data-toggle="collapse"] {
	    position: relative;
	}

	.menu [data-toggle="collapse"]:before {
	    content: "\f078";
	    font-family: "FontAwesome";
	    font-weight: 900;
	    position: absolute;
	    right: 1rem;
	}

	.menu .fa{
	    margin-right:10px;
	}

	.menu .nav-link{
	    margin-bottom:15px;
	}

	.menu .divider {
	    height: 0;
	    margin: 0.5rem 0;
	    overflow: hidden;
	    border-top: 1px solid #C2CBD8;
	}

	@media (max-width:768px) {
	    .no-scroll{
	        position:fixed;
	        overflow-y:hidden;
	    }

	    .fixed-content{
	        position:fixed;
	    }
	}
	</style>

	<!-- Sign Out  Modal -->
	<div class="modal fade" id="signOutModal" role="dialog">
	    <div class="modal-dialog">
	        <div class="modal-content">
	        <div class="modal-header">
	            <h4 class="modal-title">Sign out</h4>
	        </div>
	        <div class="modal-body">
	            <p>Are you sure you want to sign out?</p>
	        </div>
	        <div class="modal-footer">
	            <a href="signout.php" class="btn btn-success">Sign out</a>
	            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	        </div>
	        </div>
	    </div>
	</div>

	<div id="menu-overlay"> </div>

	<nav id="menu" class="menu">
	    <ul class="list-unstyled">
	        <li>
	            <a href="#submenu-user" data-toggle="collapse"><i class="fa fa-user-circle"></i> Nakeshia Lorde </a>
	            <ul id="submenu-user" class="list-unstyled collapse">
	                <li><a href="#" data-toggle="modal" data-target="#signOutModal"><i class="fa fa-fw fa-sign-out"></i> Sign Out </a></li>
	            </ul>
	        </li>

	        <div class="divider"></div>

	        <li><a href="home.php"><i class="fa fa-fw fa-tachometer"></i> My Account </a></li>
	        <li><a href="associatedaccountlist.php"><i class="fa fa-fw fa-history"></i> Account History </a></li>
	        <li><a href="billerselection2.php"><i class="fa fa-fw fa-credit-card"></i> Pay Bills </a></li>
	        <li><a href="pospayment.php"><i class="fa fa-fw fa-shopping-bag"></i> Pay Merchant </a></li>
	        <li><a href="topup.php"><i class="fa fa-fw fa-mobile" style="font-size:1.5em; width:1em"></i>Top Up Mobile </a></li>
	        <li><a href="transfer.php"><i class="fa fa-fw fa-exchange"></i> Transfer Funds </a></li>
	        <li><a href="request.php"><i class="fa fa-fw fa-money"></i> Request Funds </a></li>
	        <li><a href="nearbyagents.php"><i class="fa fa-fw fa-location-arrow"></i> Nearby Agents </a></li>

	        <div class="divider"></div>

	        <li><a href="notifications.php"><i class="fa fa-fw fa-bell-o"></i> Notifications </a></li>
	        <li><a href="settings.php"><i class="fa fa-fw fa-cog"></i> Settings </a></li>
	        <li><a href="help.php"><i class="fa fa-fw fa-question"></i> Help </a></li>
	    </ul>
	</nav><div class="footer">
	        &nbsp;
	</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>

<?php
	include "partials/menu.php"; //include slideout menu
	include "partials/footer.php";//include footer
	include "notifications/fetch.php"; //notifications
	include "notifications/insert.php"; //notifications
	include "notifications/comment.php"; //notifications
	include "notifications/link.js"; //notifications
?>
