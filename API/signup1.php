<?php
header('Content-Type: application/json');
include('db_config.php');

$response = array();

if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["hname"]) && isset($_POST["haddress"]) && isset($_POST["password"]) && isset($_FILES["dp"]) && isset($_POST["phone"]) && isset($_POST["address"])&& isset($_POST["gender"]) && isset($_POST["role"]) && isset($_POST["bday"]))
  {
	  
	  $name = $_POST["name"];
	  $mail = $_POST["email"];
	  $pass = $_POST["password"];
	  //$dp = $_POST["dp"];
	  $phone = $_POST["phone"];
	  $add = $_POST["address"];
	  $gender = $_POST["gender"];
	  $role = $_POST["role"];
	  $bday = $_POST["bday"];
	  $hname = $_POST["hname"];
	  $haddress = $_POST["haddress"];
	  
	   $newDate = date("Y-m-d", strtotime($bday));
	  
	  //check user email whether its already registered
	  $checkEmailQuery = "SELECT * FROM `tbl_login` WHERE email_id = '$mail'";
	  $result = mysqli_query($conn,$checkEmailQuery);
	  //print_r(result); exit;
	  echo mysqli_error($conn);
	  if($result->num_rows>0)
	  {
		  $response["error"] = TRUE;
		  $response["message"] = "Sorry email already found.";
		  echo json_encode($response);
		  exit;
	  }
	  else
	  {
		  
		 if(!empty($_FILES["dp"]["name"])) 
		 { 
       
        $fileName = basename($_FILES["dp"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        
        $allowTypes = array('jpg','png','jpeg','gif','JPG','PNG','JPEG','GIF'); 
        if(in_array($fileType, $allowTypes))
		{ 
			
            $image = $_FILES['dp']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 

			$ImageName = $_FILES['dp']['name']; 
			$path = 'images/'; 
			
			
			$length = 8;
            $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $alphaLength = strlen($alphabet) - 1; 
            $R = "IMG";
            for ($i = 0; $i < $length; $i++) {
                $RR = $alphabet[rand(0, $alphaLength - 1)];

                $R = $R . $RR; 
            }
						

			$ImageName = $R . $ImageName;
					
			
			if(move_uploaded_file($_FILES['dp']['tmp_name'], $path.$ImageName)) 
			{
			    	$ImageName = $path . $ImageName;
				    $signupQuery = "INSERT INTO `tbl_login`(`email_id`, `password`, `contact_no`, `l_role`, `status`) VALUES ('$mail','$pass','$phone','$role', 1)";
			         $signupResult = mysqli_query($conn,$signupQuery);
				 $id = mysqli_insert_id($conn);
				if($signupResult)
				{ 
				     $signupQuery1 = "INSERT INTO `tbl_detail`(`l_id`, `l_name`, `dob`,  `gender`, `display_pic`, `address`) VALUES ('$id','$name','$newDate','$gender','$ImageName', '$address')";
    		         $signupResult1 = mysqli_query($conn,$signupQuery1);
    		         echo mysqli_error($conn);
    		         
    		         if(!$signupResult1)
				    { 
				        	$response["error"] = TRUE;
				            $response["message"] = "Not Able to do Signed up.";
				            echo json_encode($response);
					        exit;
				        
				    }
				    
				    if($role == "2")
				    {       $signupResult2 = mysqli_query($conn,"INSERT INTO `doctor_details`(`l_id`, `hospital_name`, `hospital_address`) VALUES ('$id','$hname','$haddress')");
    		                
				         if(!$signupResult2)
    				    { 
    				        	$response["error"] = TRUE;
    				            $response["message"] = "Not Able to do Signed up.";
    				            echo json_encode($response);
    					        exit;
    				        
    				    }
				        
				    }
			  
					  $response["error"] = FALSE;
					  $response["message"] = "Successfully Signed Up.";
					  echo json_encode($response);
					  exit;
				}else
				{ 
					$response["error"] = TRUE;
					$response["message"] = "Not Able to do Signed up.";
					 echo json_encode($response);
					  exit;
				} 
			} 
			else 
			{
					$response["error"] = TRUE;
					$response["message"] = "Invalid image file.";
					 echo json_encode($response);
					  exit;
			}
			
			
			 
    		}else
    			{ 
    					$response["error"] = TRUE;
    					$response["message"] = "Invalid image file."; 
    					 echo json_encode($response);
					  exit;
    			} 
    		}
    	else
    	{ 
    				$response["error"] = TRUE;
    				$response["message"] = "Select image file."; 
    				 echo json_encode($response);
					  exit;
        } 
    		  
    		  
    		  
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