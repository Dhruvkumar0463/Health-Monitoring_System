<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();


 

 

 $checkQuery = "SELECT l.`l_id`,d.`l_name`,l.`status`  FROM `tbl_detail` d INNER JOIN `tbl_login` l ON d.`l_id`=l.`l_id` ORDER BY l.`l_id` "; // change here.
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
 

		$data = array();

		for($i=1;$i<=$numrow;$i++)
		{
			 while($val = mysqli_fetch_assoc($result))
			 {
            $details['l_id'] = $val['l_id'];
            $details['l_name'] = $val['l_name'];
            $details['status'] = $val['status'];
            

			array_push($data,$details);

			}
		}
		 $response["details"] = $data; // change in response name.
		 $response["error"] = FALSE;
		 $response["message"] = "Successfully Details data Found.";
		 echo json_encode($response);
		 exit;
 }
 
?>