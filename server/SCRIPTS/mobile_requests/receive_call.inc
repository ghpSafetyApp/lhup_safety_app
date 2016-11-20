<?php

include_once '../utilities/database_connection.inc';
include_once '../utilities/utilities.inc';

function call_request($attributes){
	
	//0: req_id, 1: username, 2: password, 3: maccaddress, 4: call type, 5: gps_lat, 6: gps_long, 7:phone
	
	$username = $attributes[1];
	$password = password_encrypt($attributes[2]);
	$mac = $attributes[3];
	$type = $attributes[4];
	$gps_lat = $attributes[5];
	$gps_long = $attributes[6];
	$phone_number = $attributes[7];
	
	$result = DBQuery("SELECT device_id FROM Devices where device_mac = '$mac'");
	
	$device_id = -10;
	
	if(mysqli_num_rows($result) > 0){
		
		$row = mysqli_fetch_assoc($result);
		
		$device_id = intval($row[0]);
		
	} else {
		//Never before seen device, add it
		//Assume device belongs to the Unknown user
		
		$result = DBQuery("INSERT INTO Devices Values(null, 0, '$mac', '$phone', 'no_hash', 2, NOW())");
		
		if($result === false){
			//Database Error
			echo 3;
			die;
		}
		
		$result = DBQuery("SELECT device_id FROM Devices where device_mac = '$mac'");
		
		if(mysqli_num_rows($result) == 0){
			//Database Error
			echo 3;
			die;
		}
		
		$row = mysqli_fetch_assoc($result);
		$device_id = intval($row[0]);
		
	}
	
	
	//$result = DBQuery("SELECT device_id From Devices JOIN EndUsers Using(end_user_id) where end_user_username = '$username' AND end_user_password = '$password' AND device_mac = '$mac'");
	
	$reuslt = DBQuery("INSERT INTO Calls Values(null, $device_id, $type, NOW(), '$gps_lat', '$gps_long', '')");
	
	if($result === false){
		//Database error
		echo 3;
		die;
	} else {
		echo 1;
		die;
	}
	
}

