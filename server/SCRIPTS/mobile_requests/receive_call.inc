<?php

include_once '../utilities/database_connection.inc';
include_once '../utilities/utilities.inc';

function call_request($attributes){
	

	$conn = DBConnect();		

	//0: req_id 1: maccaddress, 2: call type, 3: gps_lat, 4: gps_long, 5:phone
	
	$mac = mysqli_real_escape_string($conn, $attributes[1]);
	$type = mysqli_real_escape_string($conn, $attributes[2]);
	$gps_lat = mysqli_real_escape_string($conn,$attributes[3]);
	$gps_long = mysqli_real_escape_string($conn,$attributes[4]);
	$phone_number = mysqli_real_escape_string($conn,$attributes[5]);
	
	$result = mysqli_query($conn, "SELECT device_id FROM Devices where device_mac = '$mac'");
	
	$device_id = -10;
	
	if(mysqli_num_rows($result) > 0){
		
		$row = mysqli_fetch_row($result);
		
		$device_id = intval($row[0]);
		
	} else {
		//Never before seen device, add it
		//Assume device belongs to the Unknown user
		
		$result = mysqli_query($conn, "INSERT INTO Devices Values(null, -10, '$mac', '$phone', 'no_hash', 2, NOW())");
		
		if($result === false){
			DBClose($conn);
			//Database Error
			echo 3;
			die;
		}
		
		$result = mysqli_query($conn, "SELECT device_id FROM Devices where device_mac = '$mac'");
		
		if(mysqli_num_rows($result) < 1){
			//Database Error
			DBClose($conn);
			echo 3;
			die;
		}
		
		$row = mysqli_fetch_row($result);
		$device_id = intval($row[0]);
		
	}
	
	
	//$result = DBQuery("SELECT device_id From Devices JOIN EndUsers Using(end_user_id) where end_user_username = '$username' AND end_user_password = '$password' AND device_mac = '$mac'");
	
	$reuslt = mysqli_query($conn, "INSERT INTO Calls Values(null, $device_id, $type, NOW(), '$gps_lat', '$gps_long', '')");
	
	if($result === false){
		//Database error
		echo 3;
		DBClose($conn);
		die;
	} else {
		//success
		DBClose($conn);
		echo 1;
		die;
	}
	
}

