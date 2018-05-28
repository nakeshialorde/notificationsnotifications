<?php include "partials/header.php";//include header file containing stylesheets js and fonts
	include "notifications/fetch.php"; //notifications
	include "notifications/insert.php"; //notifications
	include "notifications/comment.php"; //notifications
	include "notifications/link.js"; //notifications
?>

<?php
	session_start();
	if(!isset($_SESSION["token"])){
		header("Location: index.php");
    }

	if(isset($_POST["recipientInfoType"])){
		$toAccount="";
		switch($_POST['recipientInfoType']){
			case "AccountNumber":
				$toAccount=$_POST['thirdPartyAccountNumber'];
			break;
			case "MyAccount":
				$toAccount=$_POST['myAccountSelect'];
			break;
		}
		$data=array(
			"fromRequestingParty"=>$_POST['fromRequestingParty'],
			"toRecipient"=>$_POST['recipientInfoType'],
			"toEmailAddress"=>$_POST['thirdPartyEmailAddress'],
			"toAccountNumber"=>$toAccount,
			"RequesteeEmail"=>$RequesteeEmail,
			"RequesterUserID"=>$RequesterUserID,
			"RequesteeAccountNumber"=>$RequesteeAccountNumber,
			"RequestedAmount"=>$_POST['RequestedAmount'],
			"memid"=>"",
			"pin"=>""
		);

		$jsonData = json_encode($data);
		//echo print_r($data);

		//$ch = curl_init('https://e-solutionsgroup.com:8080/api/requests/');
		$ch = curl_init('http://desktop-2ofkvje:998/api/FundsRequests/');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/CAcerts/GoDaddyRootCertificateAuthority-G2.crt");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($jsonData),
			'Authorization: Bearer ' . $_SESSION["token"])
		);

		$postResult = curl_exec($ch);
		$pos = strpos($postResult,"OKITC");
		if($pos === false){
		$message = $postResult;
		}
		else{
			header("Location: FundsRequest.php");
		}
		}

		else{
		//Get General Associated Accounts (Destination Accounts)
		$ch = curl_init('https://e-solutionsgroup.com:8080/api/AssociatedAccounts/');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/CAcerts/GoDaddyRootCertificateAuthority-G2.crt");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $_SESSION["token"])
		);

		$result = curl_exec($ch);
		$jsonResult = json_decode($result);
		curl_close($ch);

		//Get Source Associated Accounts
		$sourcech = curl_init('https://e-solutionsgroup.com:8080/api/SourceAccounts/');
		curl_setopt($sourcech, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($sourcech, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($sourcech, CURLOPT_CAINFO, getcwd() . "/CAcerts/GoDaddyRootCertificateAuthority-G2.crt");
		curl_setopt($sourcech, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $_SESSION["token"])
		);

		$sourceResult = curl_exec($sourcech);
		$jsonSourceResult = json_decode($sourceResult);
		curl_close($sourcech);
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
                            .addClass("BillerAccountNumber")
                            .text(data[i].BillerAccountNumber),
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
    });
</script>

<!DOCTYPE html>
<html class="fa-events-icons-ready">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <script src="https://use.fontawesome.com/5db033aace.js"></script>
    <link href="https://use.fontawesome.com/5db033aace.css" media="all" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous">
    </script>
    <script src="/js/request.js"></script>
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
                <li><a>Confirm Request </a></li>
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


<form id="requestForm" action="requestsuccessful.php" method="POST">

<input type="hidden" name="thirdPartyEmailAddress" value="<?php echo $_POST[" thirdPartyEmailAddress"]; ?>" />
<input type="hidden" name="thirdPartyAccountNumber" value="<?php echo $_POST[" thirdPartyAccountNumber"]; ?>" />
<input type="hidden" name="amount" value="<?php echo $_POST[" amount"]; ?>" />
<input type="hidden" name="RequestedAmount" value="<?php echo $_POST[" RequestedAmount"]; ?>" />
<input type="hidden" name="RequesteeEmail" value="<?php echo $_POST[" RequesteeEmail"]; ?>" />
<input type="hidden" name="RequesteeAccountNumber" value="<?php echo $_POST[" RequesteeAccountNumber"]; ?>" />
<input type="hidden" name="RequesterUserID" value="<?php echo $_POST[" RequesterUserID"]; ?>" />
<input type="hidden" name="FundsRequestsChargeID" value="<?php echo $_POST[" FundsRequestsChargeID"]; ?>" />
<input type="hidden" name="optional" value="optional" readonly>
<input type="hidden" name="requestsuccess" value="true" readonly>

			</div>	<label>Recipient </label>
			<p><?php echo $_POST["thirdPartyEmailAddress"]; ?></p>
			<p><?php echo $_POST["thirdPartyAccountNumber"]; ?></p>
			</li>

			<div class="form-group">
			<li class="list-group-item list-card list-card-slim">
			<label> Amount Requested*</label>
			<h2 class="theme-color-two" id ="RequestedAmount" value = "RequestedAmount">
			<?php echo $_POST["amount"]; ?></h2></p>
      <?php echo $_POST["RequestedAmount"]; ?></h2></p>
      </li>

												<li class="list-group-item list-card list-card-slim">
													<label>Charged Fees<i><span class="small text-light-grey">&nbsp;(2% of request amount.)</i></span></label>

												<script>
												var Fees = 0.02;
												var div = document.getElementById("amount");
												var amt = div.textContent;
												var FundsRequestsChargeID = amt * Fees;
												FundsRequestsChargeID = FundsRequestsChargeID.toFixed(2);
												var totalAmount = amt - FundsRequestsChargeID;
												totalAmount = totalAmount.toFixed(2);
												</script>

												</br><span id="FundsRequestsChargeID"><h2 class="theme-color-two">$
												<script type ="text/javascript">document.write(FundsRequestsChargeID);</script></h2>
												</span>

								</li>

                                <li class="list-group-item list-card list-card-slim">
                                    <label>Notes </label>
                                    <p><i><?php echo $_POST["optional"]; ?></i></p>
                                </li>

                                <li class="list-group-item list-card list-card-slim" id = "form1">
                                    <h6 class="theme-color-two">Request Summary **<?php echo $jsonResult->Description . " : " . $jsonResult->Description3; ?></h6>
                                    <div class="requestDetailRow">Request Amount: <span id="requestAmount" class="requestDetails theme-color-two">$<?php echo number_format($_POST["RequestedAmount"], 2, '.', ''); ?></span></div>
                                    <div class="requestDetailRow">Request Fee: <span id="FundsRequestsChargeID" class="requestDetails theme-color-two">$<script type ="text/javascript">document.write(FundsRequestsChargeID);</script></span>
                                    <div class="requestDetailRow">You will receive: <span id="FundsRequestsChargeID" class="requestDetails theme-color-two">$<script type ="text/javascript">document.write(totalAmount);</script></span>
                                </li>
								</br>
								<p class="description-sm">* The funds sent in response to this request will be deposited to your default account set in E-PAY. </p>
								<p class="description-sm">** This request is conditional on the third party accepting and processing the request.  </p>

                                <div id="scriptErrors"></div>

                                <div class="form-group">
                                    <?php
                                    if(isset($message)){
                                    echo "<div class='error'>" . $message . "</div>";
                                    }
                                    ?>
                                </div>
                </ul>

                <div class="form-group">
                    <div class="label"></div>
                    <a href="javascript:Cancel()" class="btn btn-danger linkButton cancelButton">Cancel</a>
                   <a id="requestSubmit" href="javascript:SubmitForm()" class="btn btn-success linkButton enabled" onclick="notifyuser()" >Request Funds</a>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>

    <div class="footer"> &nbsp; </div>

</body>
</html>
