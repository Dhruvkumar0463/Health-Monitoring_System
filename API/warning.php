<?php 
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if(isset($_POST["l_id"])){
    //login user
 
    $lid = $_POST['l_id'];
    
 
    $userQuery = "SELECT  d.`l_name`,l.`contact_no`, w.`temp_value`, w.`oxyegen_value`, w.`ecg_value`, w.`pulse_value`, w.`added_time` FROM `warning_table` w JOIN `device_table` de ON de.`device_id` = w.`device_id` JOIN `tbl_detail` d ON d.`l_id`=de.`l_id` JOIN `tbl_login` l ON d.`l_id`=l.`l_id` WHERE l.`l_id` IN ( SELECT p.`l_id` FROM `doctor_details` d INNER JOIN `patient_details` p ON d.`doc_id`=p.`doc_id` WHERE d.`l_id` = '$lid')";
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
        			$details['contact_no'] = $val['contact_no'];
        			$details['temp_value'] = $val['temp_value'];
        			$details['oxyegen_value'] = $val['oxyegen_value'];
        			$details['ecg_value'] = $val['ecg_value'];
        			$details['pulse_value'] = $val['pulse_value'];
        			$details['added_time'] = $val['added_time'];
        	
        
        
        
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