<?php

include_once '../utilities/database_connection.inc';
include_once '../utilities/utilities.inc';

function device_request($attributes){
	
	$conn = DBConnect();
	
	//0: req_id, 1: username, 2: password, 3: maccaddress, 4: phone number
	
	$username = $attributes[1];
	$password = password_encrypt($attributes[2]);
	$mac = $attributes[3];
	$phone_number = $attributes[4];
	
	file_put_contents("log.txt", "Device Hash\n", FILE_APPEND);
	$hash = device_hash($mac . $username);
	file_put_contents("log.txt", "$hash \n", FILE_APPEND);
	$end_user_id = checkUser($username, $password, $conn);
	
	$result = mysqli_query($conn, "SELECT end_user_fname, end_user_lname FROM EndUsers");
	
	$row = mysqli_fetch_row($result);
	
	$user_fname = $row[0];
	$user_lname = $row[1];
	
	
	file_put_contents("log.txt", "Before Query", FILE_APPEND);
	$result = mysqli_query($conn, "Select device_active FROM Devices Where device_mac = '$mac'");
	
	if(mysqli_num_rows($result) > 0){
		
		file_put_contents("log.txt", "Found the device \n", FILE_APPEND);
		
		while($row = mysqli_fetch_assoc($result)){
			
			$status = intval($row[0]);
			
			switch ($status){
				case 1:
					//Resend new device confirmation
					$result = mysqli_query($conn, "UPDATE Devices SET end_user_id = $end_user_id, device_hash = '$hash'");
					
					if($result == false){
						//Database error
						DBClose($conn);
						echo 3;
						die;
					}
					
					sendDeviceEmail($hash, $user_fname, $user_lname, $username);
					echo 1;
					DBClose($conn);
					break;
				case 2:
					
					
					//Device already confirmed
					echo 9;
					DBClose($conn);
					die;
					break;

				case 3:
					
					//Device Banned
					echo 8;
					DBClose($conn);
					break;
				default:
					echo 3;
					break;
			}
		}
	} else {
		//New user
		$result = mysqli_query($conn, "INSERT INTO Devices Values(null, $end_user_id,'$mac', '$phone_number', '$hash', 1, NOW())");
		
		if($result === false){
			//Database error
			file_put_contents("log.txt", "INSERT INTO Devices Values(null, $end_user_id,'$mac', '$phone_number', '$hash', 1, NOW()) \n", FILE_APPEND);
			DBClose($conn);
			echo 5;
			die;
		
		} 
		file_put_contents("log.txt", "\nSuccess \n", FILE_APPEND);
		echo 1;
		die;
	}
	
}

function sendDeviceEmail($hash, $fname, $lname, $username){
	//Code to write email
	
// Configuring SMTP server settings
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = 'safehavenlhup@gmail.com';
$mail->Password = 'safehaven123';

// Email Sending Details
$mail->addAddress($username . '@lhup.edu');
$mail->Subject = 'SafeHaven Device Registration';

$message = "<html><body><p>";
$message .= $fname . " " . $lname . " has has registered a device for \nSaveHaven. click <a href=\"" . "http://151.161.128.207/confirmed.php?uhash=". urlencode($hash) . '">here</a> to confirm your account';
$message .= "</p></body></html>";

$mail->msgHTML($message);

// Success or Failure
if (!$mail->send()) {
	return false;
}
else {
	return true;
}
	

	
}

function checkUser($username, $password, $conn){
	$result = mysqli_query($conn, "SELECT end_user_id FROM EndUsers Where end_user_username = '$username' and end_user_password = '$password'");
	if(mysqli_num_rows($result) > 0){
		//exists, get the id
		$row = mysqli_fetch_row($result);
		file_put_contents("log.txt", "Row: " . $row[0], FILE_APPEND);
		return intval($row[0]);
	} else {
		
		//If user does not exist, die
		echo 4;
		DBClose($conn);
		die;
	}
	
}


?>
