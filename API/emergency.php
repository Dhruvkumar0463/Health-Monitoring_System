<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();


 

 

 $checkQuery = "SELECT  `device_id`, `temp_value`, `oxyegen_value`, `ecg_value`, `pulse_value`, `added_time` FROM `warning_table` ORDER BY `w_id`";//change here.
 $result = mysqli_query($conn,$checkQuery);

  $numrow = mysqli_num_rows($result);
 
 if($result->num_rows == 0)
 {
	 $response["error"] = TRUE;
	 $response["message"] = "Sorry warning table data Not found.";
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

			$details['w_id'] = $val['w_id'];
			$details['device_id'] = $val['device_id'];
			$details['temp_value'] = $val['temp_value'];
            $details['oxyegen_value'] = $val['oxyegen_value'];
            $details['ecg_value'] = $val['ecg_value'];
            $details['pulse_value'] = $val['pulse_value'];
            $details['added_time'] = $val['added_time'];


			array_push($data,$details);

			}
		}
		 $response["warning"] = $data; // change in response name.
		 $response["error"] = FALSE;
		 $response["message"] = "Successfully warning table data Found.";
		 echo json_encode($response);
		 exit;
 }
 
?>