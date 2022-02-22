<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if( isset($_POST["d_id"]) && isset($_POST["p_id"]))
  {
	  
	
	  $did = $_POST["d_id"];
	  $pid = $_POST["p_id"];
	  
	 $getlid = mysqli_query($conn,"SELECT `doc_id` FROM `doctor_details` WHERE `l_id` = $did");
	 $val = mysqli_fetch_array($getlid);
	 $doc_id = $val['doc_id'];
	        
		  $signupQuery = "INSERT INTO `patient_details`(`l_id`, `doc_id`) VALUES ('$pid','$doc_id')";
		  $signupResult = mysqli_query($conn,$signupQuery);
		  
		  
		  
		  if($signupResult)
		  { 
			  
			  $response["error"] = FALSE;
			  $response["message"] = "Successfully Modified.";
			  echo json_encode($response);
			  exit;
		  }
		  else
		  {
		      
		       $response["error"] = TRUE;
			  $response["message"] = "Not Able to Modify!!";
			  echo json_encode($response);
			  exit;
		  
		  }
  }
  else
  {
	  //Invalid parameters
	  $response["error"] = TRUE;
	  $response["message"] = "Invalid Parameters";
	  echo json_encode($response);
	  exit;
  }
?>