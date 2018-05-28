<?php
	session_start();
	if(isset($_GET["transferYear"]) && isset($_GET["transferMonth"])){
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://e-solutionsgroup.com:8080/api/TransferSummaryByMonth?institutionId=8DB34F14-A886-4BDB-AC85-2351CDD0F715&transferYear=' . $_GET["transferYear"] . "&transferMonth=" . $_GET["transferMonth"],
			CURLOPT_CAINFO=> getcwd() . "/CAcerts/GoDaddyRootCertificateAuthority-G2.crt",
			CURLOPT_USERAGENT => 'COBAdmin UI',
			CURLOPT_HTTPHEADER => array(                                                                          
			'Content-Type: application/json',  
			'Authorization: Bearer ' . $_SESSION["token"]) 
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		if(!$resp){
			print_r(curl_error($curl));
		}
		else{
			//print_r($resp);
			$jsonresp = json_decode($resp);
			$transactionCount=0;
			$transactionTotal=0;
			//print_r($jsonresp);
		}
		// Close request to clear up some resources
		curl_close($curl);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>COB Admin</title>
	<link rel="stylesheet" type="text/css" href='css/dailysummary.css'>
	<script src="https://use.fontawesome.com/5db033aace.js"></script>
	<script
	  src="https://code.jquery.com/jquery-3.2.1.js"
	  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	  crossorigin="anonymous">
	</script>
</head>
<body>
	<div class="preheader">
		<div id="currentDate"><?php echo date("d/m/y");?></div>
		<div id="fromDate">From: <?php echo $_GET["transferYear"]; ?></div>
		<div id="toDate">To: <?php echo $_GET["transferMonth"]; ?></div>
	</div>
	<div class="header">
		<div class="transactionCount">Transaction Count</div>
		<div class="transactionTotal">Transaction Total</div>
	</div>
	<div class="sourceInstitutionName"><?php echo $jsonresp->SourceInstitutionName; ?></div>
	<div class="summaryTable">
		<?php foreach($jsonresp->BillerSummaries as $summary): ?>
			<div class="summaryRow">
				<div class="billerName"><?php echo $summary->BillerName; ?></div>
				<div class="transactionCount"><?php echo $summary->TransferCount; $transactionCount+= $summary->TransferCount; ?></div>
				<div class="transactionTotal"><?php echo $summary->TransferTotal; $transactionTotal+= $summary->TransferTotal; ?></div>
			</div>
		<?php endforeach; ?>
		<div class="summaryRow lastSummaryRow">
			<div class="transactionCount"><?php echo $transactionCount; ?></div>
			<div class="transactionTotal"><?php echo $transactionTotal; ?></div>
		</div>
	</div>
	<div class="totalRow subTotalRow">
		<div class="sourceInstitutionName"><?php echo $jsonresp->SourceInstitutionName; ?></div>
		<div class="subTotalLabel">Total</div>
		<div class="transactionCountSubTotal"><?php echo $transactionCount; ?></div>
		<div class="transactionSubTotal"><?php echo $transactionTotal; ?></div>
	</div>
	<div class="totalRow grandTotalRow">
		<div class="grandTotalLabel">Total</div>
		<div class="transactionCountGrandTotal"><?php echo $transactionCount; ?></div>
		<div class="transactionGrandTotal"><?php echo $transactionTotal; ?></div>
	</div>
</body>
</html>