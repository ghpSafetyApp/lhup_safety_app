<?php

include_once '../utilities/database_connection.inc';
include_once '../utilities/utilities.inc';

function register_request($attributes){
	
	$conn = DBConnect();
	
	//0: req_id, 1: email, 2: password, 3:fname, 4: lname,
	
	$username = getUsername($attributes[1]);
	
	if($username === false){
		//invalid email address
		echo "Invalid Email address";
		die;
	}
	
	$password = password_encrypt($attributes[2]);
	$fname = $attributes[3];
	$lname = $attributes[4];
	$hash = user_hash($username . $password . "qwoslfmgjsko");
	
	$result = mysqli_query($conn, "Select end_user_status FROM EndUsers Where end_user_username = '$username'");
	
	if(mysqli_num_rows($result) > 0){
		
		while($row = mysqli_fetch_assoc($result)){
			if(intval($row[0]) == 1){
				//Resend new email with new password
				$result = mysqli_query($conn, "UPDATE EndUsers SET end_user_password = '$password', end_user_fname = '$fname', end_user_lname = '$lname', end_user_hash = '$hash' where end_user_username = '$username'");
				
				if($result == false){
					//Database error
					echo "Database Error";
					die;
				}
				
				echo "success";
			} else {
				//User already confirmed
				echo "User already confirmed";
				die;
			}
		}
		
	} else {
		//New user
		$result = mysqli_query($conn, "INSERT INTO EndUsers Values(null, '$username', '$fname', '$lname', 0, '$hash', '$password')");
		
		if($result == false){
			//Database error
			echo "Database Error";
			die;
		
		} 
		
		echo "success";
		die;
	}
	
}

function sendConfirmationEmail(){
	
}

function getUsername($email){
	$parts = explode("@", $email);
	
	if(count($parts) == 2){
		
		if(strcmp($parts[1], "lhup.edu")){
			return $parts[0];
		}
		
	}
	
	return false;
}
