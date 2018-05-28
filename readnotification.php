<?php include "partials/header.php";//include header file containing stylesheets js and fonts
session_start();
if(!isset($_SESSION["token"])){
//header("Location: index.php");
}
?>

<!--<script src="js/app.js"></script>-->
<script>
    var token = "2324"; //$_SESSION["token"];
    var messageId = getQueryStringValue("notification_id");
    console.log(messageId);

    /*var source = {
                    'id': 0,
                    'message': 'notification'
    }     */

    $.ajax({
        //url: 'https://e-solutionsgroup.com:8080/api/getNotification/'+messageId,
        url:'http://desktop-8J8UQU0:998/api/FundsRequests' ?+messageId,
        type: "GET",
        crossDomain:true,
        dataType:'json',
        cache:false,
        contentType:"application/json; charset=utf-8",
        /*beforeSend:function(xhr){
            xhr.setRequestHeader("Authorization","Bearer "+token);
        },*/
        success: function(data) {
            if(data.length != 0){
                for(i=0;i<data.length;i++){
                    var notification = data[i];
                    notificationHTML = $([
                                            '<h6> '+notification.Subject+' </h6>',
                                            '<p class="text-light-grey"> '+notification.Date+' </p>',
                                            '<p> '+notification.Body+' </p>'
                                    ].join(""));

                    $("#loadingSymbol").remove();//Remove loading spinner once notifications ready for display
                    $('#notification').append(notificationHTML);//Add Notification list to page
                }
            }
        },
        error: function(error) {
            $("#loadingSymbol .fa").removeClass("fa-spinner fa-spin theme-color-two");
            $("#loadingSymbol .fa").addClass("fa-exclamation-circle");
            $("#loadingSymbol").append(" Error loading notification");
        }
    });

/*
    $(document).ready(function () {
        $("#Notifications").click(function () {

            var getNotification = new Object();
            getNotification.party = $('#party').val();
            getNotification.requested = $('#requested').val();
            getNotification.fees = $('#fees').val();
            getNotification.receive = $('#receive').val();
            getNotification.debited = $('#debited').val();
            getNotification.balance = $('#balance').val();

            $.ajax({
                url: 'https://e-solutionsgroup.com:8080/api/getNotification',
                type: 'POST',
                dataType: 'json',
                data: person,
                success: function (data, textStatus, xhr) {
                    console.log(data);
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error in Operation');
                }
            });
        });
    });
    */

/*
    $.ajax({
        url: 'users.php',
        dataType: 'json',
        type: 'post',
        contentType: 'application/json',
        data: JSON.stringify( { "first-name": $('#first-name').val(), "last-name": $('#last-name').val() } ),
        processData: false,
        success: function( data, textStatus, jQxhr ){
            $('#response pre').html( JSON.stringify( data ) );
        },
        error: function( jqXhr, textStatus, errorThrown ){
            console.log( errorThrown );
        }
    }); */
 </script>
</head>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="javascript:window.history.back()"><i class="glyphicon glyphicon-menu-left"></i> </a></li>
                <li><a> Read Notification </a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
            <li><a href="javascript:location.reload()"><i class="fa fa-refresh theme-color-two"></i></a></li>
            <li><a href="home.php"><i class="fa fa-home"></i></a></li>
            <li><a href="menu.php"><i class="fa fa-bars"></i></a></li>
            </ul>
        </div>
    </nav>

    <div class="container spacer">
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <p id="loadingSymbol" class="text-center spacer"><i class="fa fa-spinner fa-spin theme-color-two"></i></p>
                <p id="notification">
                <!-- Notification body outputs here -->
                </p>
            </div>
        </div>
    </div>


    <?php include "partials/footer.php";//include footer?>
