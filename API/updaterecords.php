<?php 
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if(isset($_POST["l_id"])){
    //update records
    $lid = $_POST["l_id"];
    $checkQuery = "SELECT l.`l_id`,l.`l_role`,d.`l_name`,d.`display_pic`,l.`email_id`, l.`contact_no`,d.`address`,l.`status`, d.`dob`, d.`gender` FROM `tbl_detail` d INNER JOIN `tbl_login` l ON d.`l_id`= l.`l_id` WHERE l.`l_id` = '$lid'"; // change here.
         $result = mysqli_query($conn,$checkQuery);
       
          $numrow = mysqli_num_rows($result);
         
         if($result->num_rows == 0)
         {
        	 $response["error"] = TRUE;
        	 $response["message"] = "Sorry Details Not found.";
        	 echo json_encode($response);
        	 exit;
         }
         else
         {
         
        
        	/*	$data = array();
        
        		for($i=1;$i<=$numrow;$i++)
        		{
        			 while($val = mysqli_fetch_assoc($result))
        			 {
                    $details['l_id'] = $val['l_id'];
                    $details['l_name'] = $val['l_name'];
        			$details['email_id'] = $val['email_id'];
        			$details['contact_no'] = $val['contact_no'];
        			$details['address'] = $val['address'];
                    $details['status'] = $val['status'];
                    $details['dob'] = $val['dob'];
                    $details['gender'] = $val['gender'];
        
        
        			array_push($data,$details);
        
        			}
        		}*/
        		$data = mysqli_fetch_assoc($result);
        		$role = $data['l_role'];
        		if($role == "2"){
        		     $doc_details = mysqli_query($conn,"SELECT `l_id`, `hospital_name`, `hospital_address` FROM `doctor_details` WHERE `l_id` = '$lid'");
        		     if($doc_details->num_rows == 0)
                     {
                    	 $response["error"] = TRUE;
                    	 $response["message"] = "Sorry Details Not found.";
                    	 echo json_encode($response);
                    	 exit;
                     }else{
                            $response["doctor"] = mysqli_fetch_assoc($doc_details);
                         	 $response["details"] = $data; // change in response name.
                    		 $response["error"] = FALSE;
                    		 $response["message"] = "Successfully Details data Found.";
                    		 echo json_encode($response);
                    		 exit;
                     }
        		     
        		}
        		 $response["details"] = $data; // change in response name.
        		 $response["error"] = FALSE;
        		 $response["message"] = "Successfully Details data Found.";
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