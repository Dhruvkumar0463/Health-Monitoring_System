<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();


 

 

 $checkQuery = "SELECT  `device_id`, `l_id`, `added_time` FROM `device_table` "; // change here.
 $result = mysqli_query($conn,$checkQuery);

  $numrow = mysqli_num_rows($result);
 
 if($result->num_rows == 0)
 {
	 $response["error"] = TRUE;
	 $response["message"] = "Sorry Device data Not found.";
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

			$details['device_id'] = $val['device_id'];
			$details['l_id'] = $val['l_id'];
			$details['added_time'] = $val['added_time'];



			array_push($data,$details);

			}
		}
		 $response["device"] = $data; // change in response name.
		 $response["error"] = FALSE;
		 $response["message"] = "Successfully Device table data Found.";
		 echo json_encode($response);
		 exit;
 }
 
?>