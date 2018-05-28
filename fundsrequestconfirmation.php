<?php include "partials/header.php";
session_start();
if(!isset($_SESSION["token"])){
  header("Location: index.php");
}
?>

<script type="text/javascript">
  function getQueryStringValue (key) {
    return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
}

$(document).ready(function(){
  var thirdPartyEmailAddress = getQueryStringValue ('thirdPartyEmailAddress');
  var thirdPartyAccountNumber = getQueryStringValue ('thirdPartyAccountNumber');
  var myAccountSelect = getQueryStringValue ('myAccountSelect');
	var amount = getQueryStringValue ('amount');
  var RequestedAmount = getQueryStringValue ('RequestedAmount');
  var RequesteeEmail = getQueryStringValue ('RequesteeEmail');
  var RequesteeAccountNumber = getQueryStringValue ('RequesteeAccountNumber');
  var RequesterUserID = getQueryStringValue ('RequesterUserID');
	var recipientInfoType = getQueryStringValue ('recipientInfoType');
	var optional = getQueryStringValue ('optional');

  $('#thirdPartyEmailAddress').val(thirdPartyEmailAddress);
  $('#thirdPartyAccountNumber').val(thirdPartyAccountNumber);
  $('#myAccountSelect').val(myAccountSelect);
  $('#amount').val(amount);
  $('#RequestedAmount').val(RequestedAmount);
  $('#RequesteeEmail').val(RequesteeEmail);
  $('#RequesteeAccountNumber').val(RequesteeAccountNumber);
  $('#RequesterUserID').val(RequesterUserID);
  $('#recipientInfoType').val(recipientInfoType);
  $('#optional').val(optional);
});

var token = "<?php echo $_SESSION["token"]; ?>";
$.ajax({
        url:"http://desktop-2ofkvje:998/api/FundsRequests/",
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
                    .addClass("FundsRequests")
                    .attr("FundsRequests",data[i].id)
                    .append(
                        $("<div></div>")
                            .addClass("FundsRequests")
														.append(
                                $("<a></a>")
                                    .attr("href","http://cobadmin.azurewebsites.net/payment/payment-details.php?id="+data[i].id)
                                    .text(data[i].FundsRequests)
                            ),
                            $("<div></div>")
                            .addClass("BillerAccountNumber")
                            .text(data[i].BillerAccountNumber),
                            $("<div></div>")
                            .addClass("AccountNumber")
                            .text(data[i].AccountNumber),
                        $("<div></div>")
                            .addClass("PaymentAmount")
                            .text(data[i].PaymentAmount),
                            $("<div></div>")
                                .addClass("RequestedAmount")
                                .text(data[i].RequestedAmount),
                                $("<div></div>")
                                    .addClass("RequesteeEmail")
                                    .text(data[i].RequesteeEmail),
                                    $("<div></div>")
                                        .addClass("FundsRequestsChargeID")
                                        .text(data[i].FundsRequestsChargeID),
                                    $("<div></div>")
                                        .addClass("RequesteeAccountNumber")
                                        .text(data[i].RequesteeAccountNumber),
                        $("<div></div>")
                            .addClass("Notes")
                            .text(data[i].Notes)
                    )
                    .appendTo("#payment-details");

              var FundsRequests = data[i];

                FundsRequestsHTML = $([
                '<option value="'+FundsRequests.FundsRequestID+'">',
                ' '+FundsRequests.Description3+' ',
                '</option>'
                ].join(""));

                $('#FundsRequests-options').append(FundsRequestsHTML);
                FundsRequestsHTML= ''; //clear HTML output var
            }
        }
    });
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
                  <input type="hidden" name="amount" value="<?php echo $_POST[" amount"]; ?>" />
                  <input type="hidden" name="RequestedAmount" value="<?php echo $_POST[" RequestedAmount"]; ?>" />
                  <input type="hidden" name="RequesteeEmail" value="<?php echo $_POST[" RequesteeEmail"]; ?>" />
                  <input type="hidden" name="RequesteeAccountNumber" value="<?php echo $_POST[" RequesteeAccountNumber"]; ?>" />
                  <input type="hidden" name="RequesterUserID" value="<?php echo $_POST[" RequesterUserID"]; ?>" />
                  <input type="hidden" name="FundsRequestsChargeID" value="<?php echo $_POST[" FundsRequestsChargeID"]; ?>" />
                  <input type="hidden" name="AccountNumber" value="<?php echo $_POST[" AccountNumber"]; ?>" />
                  <input type="hidden" name="optional" value="optional" readonly>
                  <input type="hidden" name="requestsuccess" value="true" readonly>

             </div>

            <label>Recipient </label>
            <p><?php echo $_POST["RequesteeEmail"]; ?></p>


        		<div class="fromAccount" id="show">
            <label>ChargedFees</label>
            <h2 class="theme-color-two" id="FundsRequestsChargeID" value="fromAccount">
                <p><?php echo $_POST["FundsRequestsChargeID"]; ?></p>
            </div>

            <div class="form-group" id="hide">
                <li class="list-group-item list-card list-card-slim">
                <label>  Requesting Party will receive </label>
                <h2 class="theme-color-two" id="RequestedAmount" value="myAccountControl">
                    <?php echo $_POST["RequestedAmount"]; ?>
                </h2></p>
            </li>
		</div>

		</div>

        <div class="form-group">
            <li class="list-group-item list-card list-card-slim">
                <label> Your account will be debited</label>
                <h2 class="theme-color-two" id="AccountNumber" value="AccountNumber">
                    <?php echo $_POST["AccountNumber"]; ?>
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
