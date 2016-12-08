<?php

include_once '../utilities/database_connection.inc';
include_once '../utilities/utilities.inc';
require_once '../libs/PHPMailer/PHPMailer-master/PHPMailerAutoload.php';


function register_request($email, $user_fname, $user_lname, $password, $confirm_password){
	
	$conn = DBConnect();
	
	//0: req_id, 1: email, 2: password, 3:fname, 4: lname,
	
	$username = getUsername($email);
	
	if($username === false){
		//invalid email address
		echo "Invalid email address.";
		die;
	}
	
	if(strcmp($password, $confirm_password) != 0){
		echo "Passwords do not match";
		die();
	}
	
	$password = password_encrypt($password);
	$fname = $user_fname;
	$lname = $user_lname;
	$hash = substr(user_hash($username . $password . "qwoslfmgjsko"), 7);
	
	$result = mysqli_query($conn, "Select end_user_status FROM EndUsers Where end_user_username = '$username'");
	
	if(mysqli_num_rows($result) > 0){
		
		while($row = mysqli_fetch_assoc($result)){
			if(intval($row[0]) == 1){
				//Resend new email with new password
				$result = mysqli_query($conn, "UPDATE EndUsers SET end_user_password = '$password', end_user_fname = '$fname', end_user_lname = '$lname', end_user_hash = '$hash' where end_user_username = '$username'");
				
				if($result == false){
					//Database error
					echo "Database Error.";
					die;
				}
				if(sendConfirmationEmail($username, $fname, $lname, $hash) == true) {
					echo "success";
				} else {
					echo "Failed to send email";
				}
				
				die;
				
			} else {
				//User already confirmed
				echo "User Already Confirmed";
				die;
			}
		}
		
	} else {
		//New user
		$result = mysqli_query($conn, "INSERT INTO EndUsers Values(null, '$username', '$fname', '$lname', 1, '$hash', '$password')");
		
		if($result == false){
			//Database error
			echo "Database Error";
			die;
		
		} 
		if(sendConfirmationEmail($username, $fname, $lname, $hash) == true){
			echo "success";
		} else {
			echo "Failed to send email";
		}
		
		die;
	}
	
}

function sendConfirmationEmail($username, $fname, $lname, $hash){
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
$mail->Subject = 'SafeHaven Account Confirmation';

$message = "<html><body><p>";
$message .= $fname . " " . $lname . " has requested an account for \nSaveHaven. click <a href=\"" . "http://151.161.128.207/confirmed.php?uhash=". urlencode($hash) . '">here</a> to confirm your account';
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

function getUsername($email){
	$parts = explode("@", $email);
	
	if(count($parts) == 2){
		
		if(strcmp($parts[1], "lhup.edu") == 0){
			return $parts[0];
		}
		
	}
	
	return false;
}
