<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();


 

 

 $checkQuery = "SELECT l.`l_id`,d.`l_name`,l.`contact_no`,d.`gender`,h.`hospital_name`,h.`hospital_address` FROM `tbl_login` l INNER JOIN `tbl_detail` d ON l.`l_id` = d.`l_id` INNER JOIN doctor_details h ON h.`l_id` = l.`l_id` WHERE l.`l_role` = 2 "; // change here.
 $result = mysqli_query($conn,$checkQuery);

  $numrow = mysqli_num_rows($result);
 
 if($result->num_rows == 0)
 {
	 $response["error"] = TRUE;
	 $response["message"] = "Sorry Doctor Details Not found.";
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
			$details['contact_no'] = $val['contact_no'];
			$details['gender'] = $val['gender'];
			$details['hname'] = $val['hospital_name'];
            $details['haddress'] = $val['hospital_address'];


			array_push($data,$details);

			}
		}
		 $response["doctor"] = $data; // change in response name.
		 $response["error"] = FALSE;
		 $response["message"] = "Successfully Doctor Details data Found.";
		 echo json_encode($response);
		 exit;
 }
 
?>