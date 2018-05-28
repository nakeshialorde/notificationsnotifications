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
			header("Location: requestfundsconfirmation.php");
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

<!DOCTYPE html>
	<html class="fa-events-icons-ready">
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<script src="https://use.fontawesome.com/5db033aace.js"></script><link href="https://use.fontawesome.com/5db033aace.css" media="all" rel="stylesheet">
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
	<!-- END UI UPDATE STYLES -->

<link rel="stylesheet" id="coToolbarStyle" href="chrome-extension://cjabmdjcfcfdmffimndhafhblfmpjdpe/toolbar/styles/placeholder.css" type="text/css">
<script type="text/javascript" id="cosymantecbfw_removeToolbar">
(function () {
	var toolbarElement = {},
	parent = {},
	interval = 0,
	retryCount = 0,
	isRemoved = false;
	if (window.location.protocol === 'file:') {
		interval = window.setInterval
		(function () {
			toolbarElement = document.getElementById('coFrameDiv');
			if (toolbarElement) {
				parent = toolbarElement.parentNode;
				if (parent) {
					parent.removeChild(toolbarElement);
					isRemoved = true;
					if (document.body && document.body.style) {
							document.body.style.setProperty('margin-top', '0px', 'important');
						}
					}
				}
				retryCount += 1;
				if (retryCount > 10 || isRemoved) {
					window.clearInterval(interval);
				}
			}, 10);
		}
	})();
</script>
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<ul class="nav navbar-nav">
			<li><a href="javascript:window.history.back()"><i class="glyphicon glyphicon-menu-left"></i> </a></li>
			<li><a>Request Funds</a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li><a href="home.php"><i class="fa fa-home"></i></a></li>
			<li><a><i class="fa fa-bars" id="toggle-menu"></i></a></li>
		</ul>
	</div>
</nav>

				<div class="container spacer">
				<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<form id="requestForm" action="requestfundsconfirmation.php" method="POST">
				<div class="form-group">

				<label for="recipientInfoType">Recipient</label>
				<select class="form-control" id="recipientInfoType" name="recipientInfoType">
				<option value="EmailAddress" selected>Recipient: by Email Address</option>
				<option value="AccountNumber">Recipient: by Account #</option>
				</select>
				</div>

				<div id="thirdPartyEmailAddressControl" class="form-group recipientOption">
				<label for="thirdPartyEmailAddress">Recipient: Email Address</label>
				<input type="email" id ="thirdPartyEmailAddress" name="thirdPartyEmailAddress" class="form-control" value=""/>
				</div>

				<div id="thirdPartyAccountNoControl" class="form-group recipientOption">
				<label for="thirdPartyAccountNumber">Recipient Account #</label>
				<input type="number" id="thirdPartyAccountNumber" name="thirdPartyAccountNumber" class="form-control" value="" autocomplete="on"/>
      	</div>

				<div id="RequesteeAccountNumber" class="form-group recipientOption">
				<label for="RequesteeEmail">Requesting Party Email</label>
				<input type="number" id="RequesteeEmail" name="RequesteeEmail" class="form-control" value="" autocomplete="on"/>
				</div>

				<div class="form-group">
				<label for="requestAmount">Request Amount</label>
				<div class="input-group">
				<span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-usd"></i></span>
				<input type="number" id="requestAmount" name="requestAmount" step="0.01" class="form-control" value="">
				</div>
				</div>

				<div class="form-group">
				<label for="optional"><i>Optional Note</i></label>
				<input type="text" name="optional" id="optional" class="form-control" value="">
				</div>

				<div id="errorBar">
				</div>
			  <div class="form-group">
				<p style="text-align: left;color: white;background-color: grey;padding: 10px;">
        Charges applied
        <br> <i>  Request Fee : <span id="FundsRequestsChargeID"> 2% of the request amount. </span> </i>
        </p>
        </div>

				<div class="form-group">
        <div class="label"></div>
        <a href="javascript:Cancel()" class="btn btn-danger linkButton cancelButton">Cancel</a>
        <a id="requestSubmit" href="javascript:SubmitForm()" class="btn btn-success linkButton enabled" onclick="notifyMe()">Continue</a>
        </div>
    </form>

		</div>
		</div>
		</div>

<?php
	include "partials/menu.php"; //include slideout menu
	include "partials/footer.php";//include footer
?>
