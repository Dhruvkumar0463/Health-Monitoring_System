<?php 
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if(isset($_POST["email"]) && isset($_POST["password"])){
    //login user
 
    $email = $_POST['email'];
    $password =  $_POST['password'];
 
    $userQuery = "UPDATE `tbl_login` SET `password`='$password' WHERE email_id ='$email'";
    
    $result = mysqli_query($conn,$userQuery);
  
    if(!$result){
         
        $response["error"] = TRUE;
        $response["message"] ="Operation Failed Try Again...!";
	
        echo json_encode($response);
        exit;
    }else
       
		$response["error"] = FALSE;
        $response["message"] = "Successfully Changed Password.";
        
        echo json_encode($response);
        exit;
    }
 
else {
	
    // Invalid parameters
    $response["error"] = TRUE;
    $response["message"] ="Invalid parameters";
    echo json_encode($response);
    exit;
    
    }

?>