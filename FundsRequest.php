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
			"fromAcct"=>$_POST['fromAccount'],
			"toInfoType"=>$_POST['recipientInfoType'],
			"RequesteeEmail"=>$_POST['RequesteeEmail'],
			"RequesteeAccountNumber"=>$_POST['RequesteeAccountNumber'],
			"RequesterUserID"=>$_POST['RequesterUserID'],
			"toEmailAddress"=>$_POST['thirdPartyEmailAddress'],
			"RequestedAmount"=>$_POST['RequestedAmount'],
			"toAccountNumber"=>$toAccount,
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
			header("Location: fundsrequestconfirmation.php");
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

<script type="text/javascript">*
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
    });*/
</script>

<html class="fa-events-icons-ready gr__e-solutionsgroup_com" style=""><head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link href="http://fonts.googleapis.com/css?family=Raleway:400,200" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="/js/transfer.js"></script>
	<script src="https://use.fontawesome.com/5db033aace.js"></script><link href="https://use.fontawesome.com/5db033aace.css" media="all" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous">
	</script>
	<script src="/js/transfer.js"></script>
	<!--STYLES FOR UI UPDATE -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet" href="assets/css/modify-style.css">
<link rel="stylesheet" href="assets/css/bs-custom-theme.css">
<link rel="stylesheet" href="assets/css/custom.css">
<!-- END UI UPDATE STYLES -->

<style id="__web-inspector-hide-shortcut-style__" type="text/css">
.__web-inspector-hide-shortcut__, .__web-inspector-hide-shortcut__ *, .__web-inspector-hidebefore-shortcut__::before, .__web-inspector-hideafter-shortcut__::after
{
    visibility: hidden !important;
}
</style></head>
<body data-gr-c-s-loaded="true">
<nav class="navbar navbar-default navbar-fixed-top" style="opacity: 1;">
	<div class="container">
		<ul class="nav navbar-nav">
			<li style="opacity: 1;"><a href="javascript:window.history.back()" style="opacity: 1;"><i class="glyphicon glyphicon-menu-left" style="opacity: 1;"></i> </a></li>
			<li style="opacity: 1;"><a href="javascript:preventDefault();" style="opacity: 1;"> Request Funds </a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<!--<li><a href="javascript:location.reload();"><i class="fa fa-refresh theme-color-two"></i></a></li>-->
			<li style="opacity: 1;"><a href="home.php" style="opacity: 1;"><i class="fa fa-home"></i></a></li>
			<li style="opacity: 1;"><a href="menu.php" style="opacity: 1;"><i class="fa fa-bars"></i></a></li>
		</ul>
	</div>
</nav>

<div class="container spacer" style="">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<ul class="list-group">

<form id="transferForm" action="fundsrequestconfirmation.php" method="POST">

<input type="hidden" name="thirdPartyEmailAddress" value="<?php echo $_POST[" thirdPartyEmailAddress"]; ?>" />
<input type="hidden" name="thirdPartyAccountNumber" value="<?php echo $_POST[" thirdPartyAccountNumber"]; ?>" />
<input type="hidden" name="myAccountSelect" value="<?php echo $_POST[" myAccountSelect"]; ?>" />
<input type="hidden" name="fromAccount" value="<?php echo $_POST[" fromAccount"]; ?>" />
<input type="hidden" name="SourceAccount" value="<?php echo $_POST[" SourceAccount"]; ?>" />
<input type="hidden" name="accountselect" value="<?php echo $_POST[" accountselect"]; ?>" />
<input type="hidden" name="myAccountControl" value="<?php echo $_POST[" myAccountControl"]; ?>" />
<input type="hidden" name="amount" value="<?php echo $_POST[" amount"]; ?>" />
<input type="hidden" name="RequesteeEmail"<?php echo $_POST["RequesteeEmail"]; ?> />
<input type="hidden" name="FundsRequestsChargeID"<?php echo $_POST["FundsRequestsChargeID"]; ?> />
<input type="hidden" name="RequestedAmount"<?php echo $_POST["RequestedAmount"]; ?> />
<input type="hidden" name="optional" value="optional" readonly>
<input type="hidden" name="requestsuccess" value="true" readonly>

						<li class="list-group-item list-card list-card-slim">
						<label> Requesting Party </label>
						<p><?php echo $_POST["RequesteeEmail"]; ?></p>
						<p><?php echo $_POST["SourceAccount"]; ?></p>
   					</li>

						<li class="list-group-item list-card list-card-slim">
						<label>Charged Fees </label>
						<p><?php echo $_POST["FundsRequestsChargeID"]; ?></p>
					  </li>

						<li class="list-group-item list-card list-card-slim">
						<label> Requesting Party will receive</label>
						<p><?php echo $_POST["RequestedAmount"]; ?></p>
						<p><?php echo $_POST["amount"]; ?></p>
						</li>

    				<li class="list-group-item list-card list-card-slim">
						<label>Your account will be debited</label>
						<p><?php echo $_POST["AccountNumber"]; ?></p>
						</li>

       			<li class="list-group-item list-card list-card-slim">
						<label>Balance after transaction</label>
						<span id="closingBalance" class="transDetails theme-color-two">						</li>

						</ul>

				<div id="errorBar">
				<?php
					if(isset($message)){
						echo "<div class='error'>" . $message . "</div>";
					}
				?>
				</div>

					<div class="form-group">
					<div class="label"></div>
					<a href="javascript:Cancel()" class="btn btn-danger linkButton cancelButton">Cancel</a>
					<a id="transferSubmit" href="javascript:SubmitForm()" class="btn btn-success linkButton enabled">Send Funds</a>
					</div>

			</form>

			</div>
			</div>
			</div>
</body>
<html>

















			<!--<div class="control" align="Left">
                  <div class="label"><h3 style="color:green;">Equivalent to:</h3></div>
                 <div class="control" align="left">
                    <div class="label"></div>
                    <table  width="100%" cellpadding="10" border="0">
					<tr bgcolor="#000000">
						<td style="text-align: left;" bgcolor="#ffffff"><h3 style="color:grey;">$1000.00</h3></td>
						<td style="text-align: right;" bgcolor="#ffffff">BDS</td>
					</tr>
			        <tr bgcolor="#000000">

						<td colspan="2" style="text-align: right;" bgcolor="#ffffff"><h3 style="color:grey;">Fee: $2.00BDS</h3></td>
					</tr>
					</table>
                </div>

			</div>-->



    <div class="form-group">


					   	<div class="form-group">
                  <div class="label"></div>
                  <a href="javascript:Cancel()" class="btn btn-danger linkButton cancelButton">Cancel</a>
				  <a id="transferSubmit" href="javascript:SubmitForm()" class="btn btn-success linkButton enabled">Transfer</a>
            </div>
		</div></form>

</div>
</div>
</div>

<div class="footer">
        &nbsp;
</div>

</body></html>
