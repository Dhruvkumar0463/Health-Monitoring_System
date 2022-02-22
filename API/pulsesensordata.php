<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();


if(isset($_POST["name"]))
{
    //login user
 
    $lname = $_POST['name'];

 

             $checkQuery = "SELECT `pulse_value`, `added_time` FROM `pulse_table` WHERE `device_id` = (SELECT device_id FROM device_table WHERE l_id = (SELECT l_id from tbl_detail WHERE l_name = '$lname'))"; // change here.
             $result = mysqli_query($conn,$checkQuery);
            
              $numrow = mysqli_num_rows($result);
             
             if($result->num_rows == 0)
             {
            	 $response["error"] = TRUE;
            	 $response["message"] = "Sorry no Pulse data found.";
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
            
            			$details['pulse_value'] = $val['pulse_value'];
            			$details['added_time'] = $val['added_time'];
            
            
            
            			array_push($data,$details);
            
            			}
            		}
            		 $response["pulse"] = $data; // change in response name.
            		 $response["error"] = FALSE;
            		 $response["message"] = "Successfully Pulse Sensor data Found.";
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