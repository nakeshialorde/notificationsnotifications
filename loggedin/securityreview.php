<?php
require 'includes/header.php';
	
	$descripiton='';
	$status='';
	$revieweeid='';
	$reviewId='';
	
	if(isset($_GET["revieweeid"])){
		//$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		/*
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://e-solutionsgroup.com:8080/api/COBSecurityReviews/' . $_GET["id"],
			CURLOPT_CAINFO=> getcwd() . "/CAcerts/GoDaddyRootCertificateAuthority-G2.crt",
			CURLOPT_USERAGENT => 'COBAdmin UI'
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		$jsonresp = json_decode($resp);
		$status = $jsonresp->Status;
		$description = $jsonresp->StatusDescription;
		$revieweeid= $jsonresp->RevieweeID;
		// Close request to clear up some resources
		curl_close($curl);
		*/
		$revieweeid = $_GET["revieweeid"];
	}
	
	if(isset($_GET["id"])){
		/*
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://e-solutionsgroup.com:8080/api/COBSecurityReviews/' . $_GET["id"],
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
			$jsonresp = json_decode($resp);
			$status = $jsonresp->Status;
			$description = $jsonresp->StatusDescription;
			$revieweeid= $jsonresp->RevieweeID;
		}
		// Close request to clear up some resources
		curl_close($curl);
		*/
		$reviewId=$_GET["id"];
		//echo $reviewId;
	}

	if(isset($_POST["status"])&&isset($_POST["revieweeid"])){
		
		$data=array(
			"RevieweeID"=>$_POST['revieweeid'],
			"Status"=>$_POST['status'],
			"StatusDescription"=>$_POST['statusDescription']
		);
		$jsonData = json_encode($data);
		
		$ch = curl_init('https://e-solutionsgroup.com:8080/api/COBSecurityReviewsLight');                                                                      
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
		if(!$postResult){
			print_r(curl_error($ch));
		}
		else{
			$jsonPostResult = json_decode($postResult);
			print_r($jsonPostResult);
			if(isset($jsonPostResult->RevieweeID)){
				header("Location: http://cobadmin.azurewebsites.net/loggedin/securityreview.php?id=" . $jsonPostResult->COBSecurityReviewID);
			}
		}
		curl_close($ch);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>COB Admin</title>
	<link rel="stylesheet" type="text/css" href='css/style.css'>
	<link rel="stylesheet" type="text/css" href='css/securityreview.css'>
	<script src="https://use.fontawesome.com/5db033aace.js"></script>
	<script
	  src="https://code.jquery.com/jquery-3.2.1.js"
	  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	  crossorigin="anonymous">
	</script>
	<script>
		var token = "<?php echo $_SESSION["token"]; ?>";
		var revieweeId="<?php echo $revieweeid; ?>";
		<?php if($reviewId>0) echo "var reviewId=" . $reviewId . ";"; ?>
	</script>
	<script src="js/securityreview.js"></script>
</head>
<body>
	<div id="pageContainer">
		<div id="topBar">
			<?php include 'includes/topbar.php'; ?>
		</div>
		<div id="body">
			<div id="menuBar">
				<?php include 'includes/menu.php'; ?>
			</div>
			<div id="content">
				<div id="contentHeader">
					Security Review
				</div>
				<div id="contentBody">
					<h3>Personal Information</h3>
					<div class="fieldRow">
						<span class="fieldLabel firstname">First Name</span><span class="infoField firstname"></span>
						<span class="fieldLabel lastname">Last Name</span><span class="infoField lastname"></span>
					</div>
					<div class="fieldRow">
						<span class="fieldLabel email">Email</span><span class="infoField email"></span>
					</div>
					<div id="securityQuestionResponseRow">
						<h3>Security Questions</h3>
						<div id="securityQuestionResponseList">
						</div>
					</div>
					<h3>Linked Accounts</h3>
					<div id="associatedAccountList"></div>
				</div>
				<div id="responseBar">
					<form id="responseForm" action="securityreview.php" method="POST">
						<input type="hidden" id="revieweeid" name="revieweeid" value="<?php echo $revieweeid; ?>"/>
						<table>
							<tr>
								<td>Review Status</td>
								<td>
									<select id="status" name="status">
										<option value="Approved" <?php if($status=='Approved') echo 'Selected'; ?> >Approved</option>
										<option value="Denied" <?php if($status=='Denied') echo 'Selected'; ?> >Denied</option>
									</select></td>
							</tr>
							<tr>
								<td>Status Description</td>
								<td>
									<input type="text" id="statusDescription" name="statusDescription" value="<?php echo $description; ?>"/></td>
							</tr>
						</table>
						<div>
							<input type="submit" value="Submit" id="submit" name="submit" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>