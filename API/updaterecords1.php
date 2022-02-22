<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if(isset($_POST["email"]) && isset($_POST["gender"]) && isset($_POST["role"])&& isset($_POST["hname"])&&  isset($_POST["haddress"]) && isset($_POST["phone"]) && isset($_POST["name"]) && isset($_POST["dob"]) && isset($_POST["address"]))
  {
	  
	
	  $mail = $_POST["email"];
	  $phone = $_POST["phone"];
	  $name = $_POST["name"];
	  $dob = $_POST["dob"];
	  $role = $_POST["role"];
	  $gender = $_POST["gender"];
	  $address = $_POST["address"];
	  $hname = $_POST["hname"];
	  $haddress = $_POST["haddress"];
	  
	  
	  
	  
	
	  $newDate = date("Y-m-d", strtotime($dob));
	  //check user email whether its already registered
	  
	        
	        $getlid = mysqli_query($conn,"SELECT `l_id` FROM `tbl_login` WHERE `email_id`='$mail'");
	        $val = mysqli_fetch_array($getlid);
	        $lid = $val['l_id'];
	        
		  $signupQuery = "UPDATE `tbl_login` SET `email_id`='$mail',`contact_no` = '$phone'  WHERE `l_id`='$lid'";
		  $signupResult = mysqli_query($conn,$signupQuery);
		  
		  
		  
		  if($signupResult)
		  { 
			  
    	      $signupQuery1 = "UPDATE `tbl_detail` SET  `l_name`= '$name', `dob`='$newDate',  `gender`='$gender', `address` = '$address' WHERE `l_id`='$lid'";
    		  $signupResult1 = mysqli_query($conn,$signupQuery1);
			  if($role == "2")
		     {
		         $signupResult2 = mysqli_query($conn,"UPDATE `doctor_details` SET  `hospital_name`='$hname', `hospital_address`='$haddress' WHERE `l_id`='$lid'");
		         if($signupResult2)
		         { 
		               $response["error"] = FALSE;
        			  $response["message"] = "Successfully Modified.";
        			  echo json_encode($response);
        			  exit;
		         }else{
		             $response["error"] = TRUE;
        			  $response["message"] = "Not Able to Modify!!";
        			  echo json_encode($response);
        			  exit;
		         }
		         
		     }
		     
			  
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