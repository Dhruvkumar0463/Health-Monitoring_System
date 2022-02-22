<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["gender"]) && isset($_POST["phone"]) && isset($_POST["role"]) && isset($_POST["name"]) && isset($_POST["dob"]) && isset($_POST["display_pic"]) && isset($_POST["address"]))
  {
	  
	
	  $mail = $_POST["email"];
	  $pass = $_POST["password"];
	  $phone = $_POST["phone"];
	  $role = $_POST["role"];
	  $name = $_POST["name"];
	  $dob = $_POST["dob"];
	  $gender = $_POST["gender"];
	  $display_pic = $_POST["display_pic"];
	  $address = $_POST["address"];
	  
	  
	  
	
	  $newDate = date("Y-m-d", strtotime($dob));
	  //check user email whether its already registered
	  $checkEmailQuery = "SELECT * FROM `tbl_login` WHERE email_id = '$mail'";
	  $result = mysqli_query($conn,$checkEmailQuery);
	  //print_r(result); exit;
	  
	  if($result->num_rows>0)
	  {
		  $response["error"] = TRUE;
		  $response["message"] = "Sorry email already found.";
		  echo json_encode($response);
		  exit;
	  }
	  else
	  {
		  $signupQuery = "INSERT INTO `tbl_login`(`email_id`, `password`, `contact_no`, `l_role`, `status`) VALUES ('$mail','$pass','$phone','$role', 1)";
		  $signupResult = mysqli_query($conn,$signupQuery);
		  
		  $id = mysqli_insert_id($conn);
		  
		  if($signupResult)
		  { 
			  
    	      $signupQuery = "INSERT INTO `tbl_detail`(`l_id`, `l_name`, `dob`,  `gender`, `display_pic`, `address`) VALUES ('$id','$name','$newDate','$gender','$display_pic', '$address')";
    		  $signupResult = mysqli_query($conn,$signupQuery);
			  
			  
			  $response["error"] = FALSE;
			  $response["message"] = "Successfully Signed Up.";
			  echo json_encode($response);
			  exit;
		  }
		  else
		  {
		      
		       $response["error"] = TRUE;
			  $response["message"] = "Not Able to do signup!!";
			  echo json_encode($response);
			  exit;
		  }
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