<?php

include_once '../utilities/database_connection.inc';
include_once '../utilities/utilities.inc';

function device_request($attributes){
	
	//0: req_id, 1: username, 2: password, 3: maccaddress, 4: phone number
	
	$username = $attributes[1];
	$password = password_encrypt($attributes[2]);
	$mac = $attributes[3];
	$phone_number = $attributes[4];
	
	$hash = device_hash($mac . $username);
	
	$end_user_id = checkUser($username, $password);
	
	
	
	$result = DBQuery("Select device_active, end_user_id, end_user_fname, end_user_lname FROM Devices Join EndUsers Using(end_user_id) Where device_mac = '$mac'");
	
	if(mysqli_num_rows($result) > 0){
		
		while($row = mysqli_fetch_assoc($result)){
			
			$status = intval($row[0]);
			
			switch ($status){
				case 1:
					//Resend new device confirmation
					$result = DBQuery("UPDATE Devices SET end_user_id = $end_user_id, device_hash = '$hash'");
					
					if($result == false){
						//Database error
						echo 3;
						die;
					}
					
					sendDeviceEmail($hash, $end_user_id, $row[2], $row[3]);
					echo 1;
					break;
				case 2:
					
					
					//Device already confirmed
					echo 9;
					die;
					break;

				case 3:
					
					//Device Banned
					echo 8;
					break;
				default:
					echo 3;
					break;
			}
		}
	} else {
		//New user
		$result = DBQuery("INSERT INTO Devices Values(null, '$end_user_id','$mac', '$phone_number', '$hash', 1, null");
		
		if($result == false){
			//Database error
			echo 5;
			die;
		
		} 
		
		echo 1;
		die;
	}
	
}

function sendDeviceEmail($hash, $fname, $lname, $username){
	//Code to write email
	
	$subject = "Confirm Account";
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
	
	$message = "<html><body><p>";
	$message .= $fname . " " . $lname . ' has requested an account for \nSaveHaven. click <a href="' . "http://safehaven.lhup.edu/confirmed.php" . '">here</a> to confirm your account';
	$message .= "</p></body></html>";
	
	if(mail($username, $subject, $message, $headers)) {
		echo "email sent successfully.";
	}
	else {
		echo "failed. try again.";
	}
	
}

function checkUser($username, $password){
	
	$result = DBQuery("SELECT end_user_id FROM EndUsers Where end_user_username = '$username' and end_user_password = '$password'");
	
	if(mysqli_num_rows($result) > 0){
		//exists, get the id
		$row = mysqli_fetch_assoc($result);
		return intval($row[0]);
	} else {
		//If user does not exist, die
		echo 4;
		die;
	}
	
}


?>