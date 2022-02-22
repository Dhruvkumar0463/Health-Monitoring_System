<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();


 

 

 $checkQuery = "SELECT l.`l_id`,d.`l_name`,d.`gender`,d.`dob`,l.`contact_no`,d.`address` FROM `tbl_login` l INNER JOIN `tbl_detail` d ON l.`l_id` = d.`l_id` WHERE l.`l_role` = 1"; // change here.
 $result = mysqli_query($conn,$checkQuery);

  $numrow = mysqli_num_rows($result);
 
 if($result->num_rows == 0)
 {
	 $response["error"] = TRUE;
	 $response["message"] = "Sorry Patient Details Not found.";
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
			$details['gender'] = $val['gender'];
			$details['dob'] = $val['dob'];
			$details['contact_no'] = $val['contact_no'];
            $details['address'] = $val['address'];


			array_push($data,$details);

			}
		}
		 $response["patient"] = $data; // change in response name.
		 $response["error"] = FALSE;
		 $response["message"] = "Successfully Patient Details Found.";
		 echo json_encode($response);
		 exit;
 }
 
?>