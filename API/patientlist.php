<?php 
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if(isset($_POST["l_id"])){
    //login user
 
    $lid = $_POST['l_id'];
    
 
    $userQuery = "SELECT d.`l_name`, d.`dob`, d.`gender`, d.`display_pic`,l.`contact_no` FROM `tbl_detail` d INNER JOIN `tbl_login` l ON d.`l_id`=l.`l_id` WHERE l.`l_id` IN ( SELECT p.`l_id` FROM `doctor_details` d INNER JOIN `patient_details` p ON d.`doc_id`=p.`doc_id` WHERE d.`l_id` = '$lid')";
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
         
        
        		$data = array();
        
        		for($i=1;$i<=$numrow;$i++)
        		{
        			 while($val = mysqli_fetch_assoc($result))
        			 {
        
        			$details['l_name'] = $val['l_name'];
        			$details['dob'] = $val['dob'];
        			$details['gender'] = $val['gender'];
        			$details['contact_no'] = $val['contact_no'];
        			$details['display_pic'] = $val['display_pic'];
        
        
        
        			array_push($data,$details);
        
        			}
        		}
        		 $response["details"] = $data; // change in response name.
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