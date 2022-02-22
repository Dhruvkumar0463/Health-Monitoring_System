<?php 
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if(isset($_POST["l_id"])){
    //login user
 
    $lid = $_POST['l_id'];
    
 
    $userQuery = "SELECT d.`display_pic`,d.`l_name`, l.`contact_no` FROM `tbl_detail` d INNER JOIN `tbl_login` l ON d.`l_id`=l.`l_id` WHERE l.`l_id` IN ( SELECT `l_id` FROM `doctor_details` WHERE `doc_id` = (SELECT `doc_id` from patient_details WHERE `l_id` = '$lid'))";
    $result = mysqli_query($conn,$userQuery);
  
    $numrow = mysqli_num_rows($result);
 
         if($result->num_rows == 0)
         {
        	 $response["error"] = TRUE;
        	 $response["message"] = "Sorry no data found.";
        	 echo json_encode($response);
        	 exit;
         }
         else
         {
                 $response["details"] = mysqli_fetch_assoc($result);
        		 $response["error"] = FALSE;
        		 $response["message"] = "Successfully  data Found.";
        		 echo json_encode($response);
        		 exit;
         }
}
else {
	
    // Invalid parameters
    $response["error"] = TRUE;
    $response["message"] ="Invalid parameters";
    echo json_encode($response);
exit;}

?>