<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if( isset($_POST["l_id"]) )
  {
	  
	
	  $lid = $_POST["l_id"];
	  
     $pulse = mysqli_query($conn,"SELECT p.pulse_value FROM pulse_table p JOIN device_table d ON p.device_id = d.device_id WHERE d.`l_id` = '$lid' ORDER BY p.`added_time` DESC LIMIT 1");
	 $spo2 = mysqli_query($conn,"SELECT o.`oxygen_value` FROM oxygen_table o JOIN device_table d ON o.device_id = d.device_id WHERE d.`l_id` = '$lid' ORDER BY o.`added_time` DESC LIMIT 1");
	 $ecg = mysqli_query($conn,"SELECT e.`ecg_value` FROM ecg_table e JOIN device_table d ON e.device_id = d.device_id WHERE d.`l_id` = '$lid' ORDER BY e.`added_time` DESC LIMIT 1");
	 $temp = mysqli_query($conn,"SELECT t.`temp_value` FROM temperature_table t JOIN device_table d ON t.device_id = d.device_id WHERE d.`l_id` = '$lid' ORDER BY t.`added_time` DESC LIMIT 1");
	 
	
		  
		  if($pulse->num_rows != 0 && $spo2->num_rows != 0 && $ecg->num_rows != 0 && $temp->num_rows != 0)
		  { 
			  $val1 = mysqli_fetch_array($pulse);
        	 $val2 = mysqli_fetch_array($spo2);
        	 $val3 = mysqli_fetch_array($ecg);
        	 $val4 = mysqli_fetch_array($temp);
        	 
    			  $response["error"] = FALSE;
		        $response["pulse"] = $val1['pulse_value'];
		        $response["spo2"] = $val2['oxygen_value'];
		        $response["temp"] = $val4['temp_value'];
		        $response["ecg"] = $val3['ecg_value'];
			     $response["message"] = "Successfully Found.";
			     echo json_encode($response);
			    exit; 
		  }
		  else
		  {
		      
		       $response["error"] = TRUE;
			  $response["message"] = "Not Records Found!!";
			  echo json_encode($response);
			  exit;
		  
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