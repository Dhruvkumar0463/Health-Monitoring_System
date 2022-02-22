<?php 
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if(isset($_POST["l_id"])){
    //update records
    $lid = $_POST["l_id"];
    
    $getStatus = mysqli_query($conn,"SELECT  `status` FROM `tbl_login` WHERE `l_id` = '$lid'");
   
         if($getStatus->num_rows !== 0)
         {          
             
             $val = mysqli_fetch_array($getStatus);
        	$status = $val['status'];
        	if ($status === "1") {
              $status = "0";
            } else {
              $status = "1";
            }
            $checkQuery = "UPDATE `tbl_login` SET `status`='$status' WHERE `l_id`='$lid'";
            $result = mysqli_query($conn,$checkQuery);
                
           
                 if($result)
                 { 
                     $response["error"] = FALSE;
            		 $response["message"] = "Successfully Modified Status.";
            		 echo json_encode($response);
            		 exit;
                 }
                 else{
                      $response["error"] = TRUE;
                	 $response["message"] = "Sorry Try Again Could not update STATUS.";
                	 echo json_encode($response);
                	 exit;
                     
                 }
        	  
         }
         else
         {
        		
        		  $response["error"] = TRUE;
                	 $response["message"] = "Please Select correct l_id.";
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