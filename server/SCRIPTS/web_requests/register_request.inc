<?php

include_once '../utilities/database_connection.inc';
include_once '../utilities/utilities.inc';

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
	$hash = user_hash($username . $password . "qwoslfmgjsko");
	
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
	
	$from = "safehaven@noreply.com";
	$to = $username . "@lhup.edu";
	$subject = "Confirm Account";
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
	
	$message = "<html><body><p>";
	$message .= $fname . " " . $lname . ' has requested an account for \nSaveHaven. click <a href="' . "http://safehaven.lhup.edu/confirmed.php" . '">here</a> to confirm your account';
	$message .= "</p></body></html>";
	
	if(mail($to, $subject, $message, $headers)) {
		return true;
	}
	else {
		return false;
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
