<?php include "partials/header.php";
/*session_start();
if(!isset($_SESSION["token"])){
  header("Location: index.php");
}*/
?>

<script type="text/javascript"> /* 
  function getQueryStringValue (key) {
    return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
}

$(document).ready(function(){
    var recipientInfoType = getQueryStringValue('recipientInfoType');
    var thirdPartyEmailAddress = getQueryStringValue ('thirdPartyEmailAddress');
    var myAccountSelect = getQueryStringValue('myAccountSelect');
    var fromAccount = getQueryStringValue('fromAccount');
	var sourceAccount = getQueryStringValue('sourceAccount');
	var  accountselect = getQueryStringValue('accountselect');
    var myAccountControl = getQueryStringValue('myAccountControl');
    var amount = getQueryStringValue ('amount');
	var optional = getQueryStringValue ('optional');
	var 

  $('#recipientInfoType').val(recipientInfoType);
  $('#thirdPartyEmailAddress').val(thirdPartyEmailAddress);
  $('#myAccountSelect').val(myAccountSelect);
  $('#fromAccount').val(fromAccount);
  $('#myAccountControl').val(myAccountControl);
  $('#sourceAccount').val(sourceAccount);
  #('accountselect').val(accountselect);
  $('#amount').val(amount);
  $('#optional').val(optional);
});

var token = "<?php echo $_SESSION["token"]; ?>";

$.ajax({
        url:"https://e-solutionsgroup.com:8010/api/SourceAccounts",
        crossDomain:true,
        dataType:'json',
        cache:false,
        contentType:"application/json; charset=utf-8",
        beforeSend:function(xhr){
            xhr.setRequestHeader("Authorization","Bearer "+token);
        },
        success:function(data){
            for(i=0;i<data.length;i++){
                $("<div></div>")
                    .addClass("Account-SourceAccount")
                    .attr("Account-SourceAccount",data[i].id)
                    .append(
                        $("<div></div>")
                            .addClass("SourceAccount")
                            .append(
                                $("<a></a>")
                                    .attr("href","http://cobadmin.azurewebsites.net/payment/payment-details.php?id="+data[i].id)
                                    .text(data[i].SourceAccount)
                    ),
                    $("<div></div>")
                        .addClass("recipientInfoType")
                        .text(data[i].recipientInfoType),
                    $("<div></div>")
                        .addClass("thirdPartyEmailAddress")
                        .text(data[i].thirdPartyEmailAddress),
                    $("<div></div>")
                        .addClass("myAccountSelect")
                        .text(data[i].myAccountSelect),
                    $("<div></div>")
                        .addClass("fromAccount")
                        .text(data[i].fromAccount),
					$("<div></div>")
                        .addClass("sourceAccount")
                        .text(data[i].sourceAccount)
					$("<div></div>")
                        .addClass("accountselect")
                        .text(data[i].accountselect)
                    $("<div></div>")
                        .addClass("myAccountControl")
                        .text(data[i].myAccountControl),
                        $("<div></div>")
                            .addClass("PaymentAmount")
                            .text(data[i].PaymentAmount),
                        $("<div></div>")
                            .addClass("Notes")
                            .text(data[i].Notes)
                    )
                    .appendTo("#payment-details");

              var sourceAccount = data[i];
                //build HTML output for source Account list

                sourceAccountHTML = $([
                '<option value="'+sourceAccount.AssociatedAccountID+'">',
                ' '+sourceAccount.Description3+' ',
                '</option>'
                ].join(""));

                $('#source-account-options').append(sourceAccountHTML);//Add the source accounts to drop down
                sourceAccountHTML= ''; //clear HTML output var
            }
        }
    });*/
</script>

<!DOCTYPE html>
<html class="fa-events-icons-ready">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <script src="https://use.fontawesome.com/5db033aace.js"></script>
    <link href="https://use.fontawesome.com/5db033aace.css" media="all" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="/js/transfer.js"></script>
    <!--STYLES FOR UI UPDATE -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="assets/css/modify-style.css">
    <link rel="stylesheet" href="assets/css/bs-custom-theme.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- END UI UPDATE STYLES -->
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="javascript:window.history.back()"><i class="glyphicon glyphicon-menu-left"></i> </a></li>
                <li><a>Confirm Transfer</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <!--<li><a href="javascript:location.reload();"><i class="fa fa-refresh theme-color-two"></i></a></li>-->
                <li><a href="home.php"><i class="fa fa-home"></i></a></li>
                <li><a><i class="fa fa-bars" id="toggle-menu"></i></a></li>
            </ul>
        </div>
    </nav>

    <div class="container spacer" style="">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <ul class="list-group">

                <form id="transferForm" action="transfersuccessful.php" method="POST">

                    <input type="hidden" name="thirdPartyEmailAddress" value="<?php echo $_POST[" thirdPartyEmailAddress"]; ?>" />
                    <input type="hidden" name="thirdPartyAccountNumber" value="<?php echo $_POST[" thirdPartyAccountNumber"]; ?>" />
                    <input type="hidden" name="myAccountSelect" value="<?php echo $_POST[" myAccountSelect"]; ?>" />
                    <input type="hidden" name="fromAccount" value="<?php echo $_POST[" fromAccount"]; ?>" />
					<input type="hidden" name="SourceAccount" value="<?php echo $_POST[" SourceAccount"]; ?>" />
					<input type="hidden" name="accountselect" value="<?php echo $_POST[" accountselect"]; ?>" />
                    <input type="hidden" name="myAccountControl" value="<?php echo $_POST[" myAccountControl"]; ?>" />
                    <input type="hidden" name="amount" value="<?php echo $_POST[" amount"]; ?>" />
                    <input type="hidden" name="optional" value="optional" readonly>
                    <input type="hidden" name="requestsuccess" value="true" readonly>

         </div>	
        
        <label>Recipient </label>
        <p><?php echo $_POST["thirdPartyEmailAddress"]; ?></p>
        <p><?php echo $_POST["thirdPartyAccountNumber"]; ?></p>
        <p><?php echo $_POST["myAccountSelect"]; ?></p>
       
		<script>
			function accountdisplay() {
			document.getElementById("myAccountSelect").style.visibility = "show";
		}
		</script>

		<div class="account" onshow="accountdisplay()">

		<div class="fromAccount" id="show">
            <label>Source Account</label>
            <h2 class="theme-color-two" id="fromAccount" value="fromAccount">
                <p><?php echo $_POST["fromAccount"]; ?></p>
        </div>

        <div class="form-group" id="hide">
            <li class="list-group-item list-card list-card-slim">
                <label> Destination Account </label>
                <h2 class="theme-color-two" id="myAccountControl" value="myAccountControl">
                    <?php echo $_POST["myAccountControl"]; ?>
                </h2></p>
            </li>
		</div>

		</div>

        <div class="form-group">
            <li class="list-group-item list-card list-card-slim">
                <label> Transfer Amount</label>
                <h2 class="theme-color-two" id="amount" value="amount">
                    <?php echo $_POST["amount"]; ?>
                </h2></p>
            </li>
		</div>

            <li class="list-group-item list-card list-card-slim">
                <label>Notes </label>
                <p><i><?php echo $_POST["optional"]; ?></i></p>
            </li>

            <div class="form-group">
                <?php
                if(isset($message)){
                echo "<div class='error'>" . $message . "</div>";
                }
                ?>
            </div>

            <div id="scriptErrors"></div>
            </ul>

            <div class="form-group">
                <div class="label"></div>
                <a href="javascript:Cancel()" class="btn btn-danger linkButton cancelButton">Cancel</a>
                <a id="requestSubmit" href="javascript:SubmitForm()" class="btn btn-success linkButton enabled">Transfer Funds</a>
            </div>
        </div>
        </form>
    </div>
    </div>
    </div>

    <div class="footer"> &nbsp; </div>

</body>
</html>