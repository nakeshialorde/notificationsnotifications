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
			"toEmailAddress"=>$_POST['thirdPartyEmailAddress'],
			"toAccountNumber"=>$toAccount,
			"amount"=>$_POST['amount'],
			"memid"=>"",
			"pin"=>""
		);
		$jsonData = json_encode($data);
		//echo print_r($data);
		
		$ch = curl_init('https://e-solutionsgroup.com:8010/api/transfers/');                                                                      
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
		//$jsonPostResult = json_decode($postResult);
		//if($jsonPostResult->Successful){
		//	$_SESSION["topUpMessage"] = $jsonPostResult->Message;
		//	header("Location: http://e-solutionsgroup.com/topup2.php");
		//}
		$pos = strpos($postResult,"OKITC");
		if($pos === false){
			$message = $postResult;
		}
		else{
			header("Location: transferconfirmation.php");
		}
		
		
	}
	else{
		//Get General Associated Accounts (Destination Accounts)
		$ch = curl_init('https://e-solutionsgroup.com:8010/api/AssociatedAccounts/');                                                                      
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
		$sourcech = curl_init('https://e-solutionsgroup.com:8010/api/SourceAccounts/');                                                                      
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
			<li><a href="javascript:window.history.back()"><i class="glyphicon glyphicon-menu-left"></i> </a></li>
			<li><a> Transfer Funds </a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<!--<li><a href="javascript:location.reload();"><i class="fa fa-refresh theme-color-two"></i></a></li>-->
			<li><a href="home.php"><i class="fa fa-home"></i></a></li>
			<li><a><i class="fa fa-bars" id="toggle-menu" ></i></a></li>		
		</ul>
	</div>
</nav>

<div  id="main" class="container spacer">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<form id="transferForm" action="transfer.php" method="POST">
		<div class="form-group">
		<label for="recipientInfoType">Recipient</label>
					<select class="form-control" id="recipientInfoType" name="recipientInfoType">
						<option value="EmailAddress" selected>Third Party: by Email Address</option>
						<option value="AccountNumber">Third Party: by Account #</option>
						<option value="MyAccount">My Account</option>
					</select>				
			</div>     

			<div id="thirdPartyEmailAddressControl" class="form-group recipientOption">
			<label for="thirdPartyEmailAddress">Third Party: Email Address</label>
			      
			<!--<div id="thirdPartyEmailAddressControl" class="control recipientOption" align="Left">
                  <div class="label"><h3 style="color:green;">Third Party: Email Address</h3></div>
                <div class="control" align="left"> 
                    <div class="label"></div>-->
					<input type="email" name="thirdPartyEmailAddress" class="form-control" value=""/>	
				<!--</div>	-->
			</div>
			

			<div id="thirdPartyAccountNoControl" class="form-group recipientOption">
			<label for="thirdPartyAccountNumber">Third Party: Account #</label>

			<!--<div id="thirdPartyAccountNoControl" class="control recipientOption" align="Left">
                  <div class="label"><h3 style="color:green;">Third Party: Account #</h3></div>
                <div class="control" align="left">
                    <div class="label"></div>-->
                    <input type="number" name="thirdPartyAccountNumber" class="form-control" value=""/>
                <!--</div>	-->			
			</div>
			

		<!-- Source Account displayed before My Account - Update 11/1/2017 -Fabian -->
			
		<div class="form-group">
		<label for="fromAccount">Source Account</label>
			
		 <!--  <div class="control" align="left">
                  <div class="label"><h3 style="color:black;">Select Source Account</h3></div>
                <div class="control" align="left">		-->		
				<select class="form-control" name="fromAccount">
				<?php
					foreach($jsonSourceResult as $account){
						echo "<option value='" . $account->AssociatedAccountID . "'>" .$account->Description ."-". $account->Description3 . "</option>";
					}
				?>
				</select>
				<!-- </div> -->
			</div>	

			
			<div id="myAccountControl" class="form-group recipientOption">
			<label for="myAccountControl">Destination Account</label>
           <!--<div id="myAccountControl" class="control recipientOption" align="Left">
                  <div class="label"><h3 style="color:green;">My Account</h3></div>
                	<div class="control" align="left">
                    <div class="label"></div> -->
					<select class="form-control" id="myAccountSelect" name="myAccountSelect">
						<?php
							foreach(array_reverse($jsonResult) as $account){
								echo "<option value='" . $account->AccountNumber . "'>" .$account->Description ."-". $account->Description3 . "</option>";
							}
						?>					
					</select>
               <!-- </div>	-->			
			</div>


			
			<div class="form-group">
		<label for="amount">Transfer Amount</label>
			<!--<div class="control" align="Left">
                  <div class="label"><h3 style="color:green;">Transfer Amount</h3></div>
                <div class="control" align="left">
					<div class="label"></div>-->
					<div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-usd"></i></span>
					<input type="number" id="amount" name="amount" step="0.01" class="form-control" value=""/>
						</div>
               <!-- </div> -->		
				
            </div>
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
		<label for="optional"><i>Optional Note</i></label>
			<!--<div class="control" align="Left">
                  <div class="label"><h6 style="color:green;">Optional Note:</h6></div>
                <div class="control" align="left">
                    <div class="label"></div> -->
                    <input type="text" name="optional" class="form-control" value=""/>
                <!-- </div>	-->			
				
            </div>
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
				  <a id="transferSubmit" href="javascript:SubmitForm()" class="btn btn-success linkButton enabled" >Transfer</a>
            </div>
		</form>	  

</div>
</div>
</div>

<?php 
	include "partials/menu.php"; //include slideout menu 
	include "partials/footer.php";//include footer
?> 