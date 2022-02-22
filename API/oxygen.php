<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();



if(isset($_GET["oxygen"]))
{
	  date_default_timezone_set('Asia/Kolkata');
    $timestamp = date("Y-m-d H:i:s");

	  $oxygen = $_GET["oxygen"];
// 	  $stmt = mysqli_query($conn," SELECT MAX(`oxygen_id`) FROM oxygen_table");
// 	  $val = mysqli_fetch_assoc($stmt);
// 	  $max = $val['oxygen_id'];
	  
// 	  $my = mysqli_query($conn,"ALTER TABLE `oxygen_table` AUTO_INCREMENT= '$max +1 '");
	    
	  $query = "INSERT INTO `oxygen_table`( `device_id`, `oxygen_value`, `added_time`)   VALUES('1','$oxygen','$timestamp')";
	 
	  $result = mysqli_query($conn,$query);
	  
	
	
	  
	  if($result)
	  {
	
		  
			  $response["error"] = FALSE;
			  $response["message"] = "Successfully added.";
			  echo json_encode($response);
			  exit;
	  }
	  else
	  {
		  
	  	  $response["error"] = TRUE;
		  $response["message"] = "Sorry not able to insert";
		  $response["errr"] = mysqli_error($conn);
		  echo json_encode($response);
			  
		  
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