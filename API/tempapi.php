<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();



if(isset($_GET["temp"]) )
{
	  

date_default_timezone_set('Asia/Kolkata');
$timestamp = date("Y-m-d H:i:s");
	  $temp = $_GET["temp"];
	  

	  $query = "INSERT INTO `temperature_table`( `device_id`, `temp_value`, `added_time`) VALUES('1','$temp','$timestamp')";
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