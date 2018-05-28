<script>
$(document).ready(function () {
    // toggle sidebar when button clicked
    $("#toggle-menu").click(function () {
        $(".menu").toggleClass("open");
        $("#menu-overlay").toggleClass("show");
        if($("#submenu-user").hasClass("in")){
            $("#submenu-user").removeClass("in");
        }
        toggleBodyScroll();
    });
});

$(document).on("touchmove mouseup", function(e) 
{
   
    if($("#menu").hasClass("open")){
        //e.preventDefault();
        var container = $(".menu");
        //if the target of the click isn't the container,a descendant of the container or the menu icon
        if (!container.is(e.target) && container.has(e.target).length === 0 && e.target.id != "toggle-menu") 
        {   
            container.removeClass("open");   
            $("#menu-overlay").removeClass("show");
            toggleBodyScroll();
        }
    }
});

var currentScrollPos; //track the current window position when menu opened to avoid window reseting to top when menu closed

function toggleBodyScroll(){
    winPos = $(window).scrollTop();
    if($("#menu").hasClass("open")){
        $("body").addClass("no-scroll");
        $("body").css("top", - winPos + "px");
        $("#main").addClass("fixed-content");
        currentScrollPos = winPos;
    }else{
        $("body").removeClass("no-scroll");
        $("#main").removeClass("fixed-content");
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
            <a href="#submenu-user" data-toggle="collapse"><i cl+ass="fa fa-user-circle"></i> <?php echo $_SESSION["fullName"]; ?> </a>
            <ul id="submenu-user" class="list-unstyled collapse">
                <li><a data-toggle="modal" data-target="#signOutModal" ><i class="fa fa-fw fa-sign-out"></i> Sign Out </a></li>
            </ul>
        </li>

        <div class="divider"></div>  
        
        <li><a href="home.php"><i class="fa fa-fw fa-tachometer"></i> My Account </a></li>        
        <li><a href="associatedaccountlist.php"><i class="fa fa-fw fa-history"></i> Account History </a></li>
        <li><a href="billerselection2.php"><i class="fa fa-fw fa-credit-card"></i> Pay Bills </a></li>        
        <li><a href="topup.php"><i class="fa fa-fw fa-mobile" style="font-size:1.5em; width:1em"></i>Top Up Mobile </a></li>
        <li><a href="transfer.php"><i class="fa fa-fw fa-exchange"></i> Transfer Funds </a></li>        
        <li><a href="request.php"><i class="fa fa-fw fa-money"></i> Request Funds </a></li>
        <li><a href="pospayment.php"><i class="fa fa-fw fa-shopping-bag"></i> Pay Merchant </a></li>

        <li><a href="nearbyagents.php"><i class="fa fa-fw fa-location-arrow"></i> Nearby Agents </a></li>

        <div class="divider"></div> 

        <li><a href="notifications.php"><i class="fa fa-fw fa-bell-o"></i> Notifications </a></li>
        <li><a href="settings.php"><i class="fa fa-fw fa-cog"></i> Settings </a></li>
        <li><a href="help.php"><i class="fa fa-fw fa-question"></i> Help </a></li>
    </ul>
</nav>