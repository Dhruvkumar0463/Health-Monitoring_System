<?php 
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if(isset($_POST["email"]) && isset($_POST["password"])){
    //login user
 
    $email = $_POST['email'];
    $password =  $_POST['password'];
 
    $userQuery = "SELECT `l_id`, `email_id`, `password`, `contact_no`, `l_role`, `status` FROM `tbl_login` WHERE  email_id = '$email' && password = '$password'";
    $query = mysqli_query($conn,"SELECT `l_name`,`gender`,`display_pic` FROM `tbl_detail` WHERE l_id IN( SELECT `l_id` FROM `tbl_login` WHERE  email_id = '$email' && password = '$password' )");
    $result = mysqli_query($conn,$userQuery);
  
    if($result->num_rows==0){
         
        $response["error"] = TRUE;
        $response["message"] ="user not found or Invalid login details.";
		$data = array(
		
		"LOGIN_ID" => NULL,
		"NAME" => NULL,
		"EMAIL" => NULL,
		"PHONE" => NULL,
		"PASSWORD" => NULL,
		"ROLE" => NULL,
		"GENDER" => NULL,
		"DOB" => NULL,
		"ADDRESS" => NULL,
		"DP" => NULL,
		
		
		);
		$response["user"] = $data;
	
        echo json_encode($response);
        exit;
    }else
        $user = mysqli_fetch_assoc($result);
        $detail = mysqli_fetch_assoc($query);
		$response["error"] = FALSE;
        $response["message"] = "Successfully logged in.";
        $response["user"] = $user;
        $response["detail"] = $detail;
        echo json_encode($response);
        exit;
    }
 
else {
	
    // Invalid parameters
    $response["error"] = TRUE;
    $response["message"] ="Invalid parameters";
    echo json_encode($response);
exit;}

?>